<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'floor',
        'unit_number',
        'tenant_name',
        'tenant_phone',
        'tenant_national_id',
        'duration',
        'start_date',
        'end_date',
        'rent_amount',
        'insurance_amount',
        'annual_increase_start_date',
        'annual_increase_rate',
        'service_fees',
        'status',
        'notes',
        'file_path',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'annual_increase_start_date' => 'date',
        'rent_amount' => 'decimal:2',
        'insurance_amount' => 'decimal:2',
        'service_fees' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Check if contract is expired based on end_date
     */
    public function getIsExpiredAttribute(): bool
    {
        if ($this->status === 'expired' || $this->status === 'terminated') {
            return true;
        }

        return $this->end_date ? Carbon::parse($this->end_date)->isPast() : false;
    }

    /**
     * Get computed status: ساري / منتهي / مفسوخ
     */
    public function getCalculatedStatusAttribute(): string
    {
        if ($this->status === 'terminated') {
            return 'terminated';
        }

        if ($this->is_expired) {
            return 'expired';
        }

        return 'active';
    }

    /**
     * Get Arabic Status Label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->calculated_status) {
            'active' => 'ساري',
            'expired' => 'منتهي',
            'terminated' => 'مفسوخ',
            default => 'غير محدد',
        };
    }

    /**
     * Parse annual increase rate(s) into structured rules
     *
     * @return array<int, array{type: string, value: float}>
     */
    public function extractAnnualIncreaseRates(): array
    {
        $text = trim((string) ($this->annual_increase_rate ?? ''));
        if (empty($text) || str_contains($text, 'بدون') || str_contains($text, 'لا يوجد')) {
            return [];
        }

        // Percentage matches (e.g. "10%", "10% ... 15%")
        if (preg_match_all('/(\d+(?:\.\d+)?)\s*%/u', $text, $matches)) {
            $rates = [];
            foreach ($matches[1] as $val) {
                $rates[] = [
                    'type' => 'percent',
                    'value' => (float) $val / 100.0,
                ];
            }
            return $rates;
        }

        // Numeric string (e.g. "10" or "0.10")
        if (is_numeric($text)) {
            $num = (float) $text;
            $val = $num > 1 ? $num / 100.0 : $num;
            return [[
                'type' => 'percent',
                'value' => $val,
            ]];
        }

        // Fixed amount increase (e.g. "500 جنيه" or "500 ج.م")
        if (preg_match('/(\d+(?:\.\d+)?)\s*(?:جنيه|ج\.م|ج)/u', $text, $matches)) {
            return [[
                'type' => 'fixed',
                'value' => (float) $matches[1],
            ]];
        }

        return [];
    }

    /**
     * Get effective date when the first annual increase applies
     */
    public function getEffectiveAnnualIncreaseStartDateAttribute(): ?Carbon
    {
        if ($this->annual_increase_start_date) {
            $date = Carbon::parse($this->annual_increase_start_date)->startOfDay();
            if ($this->start_date && $date->lte(Carbon::parse($this->start_date)->startOfDay())) {
                return Carbon::parse($this->start_date)->startOfDay()->addYear();
            }
            return $date;
        }

        // Extract date from rate description text if present (e.g. "اعتبارا من 1/5/2026")
        if ($this->annual_increase_rate && preg_match('/(?:اعتبارا|اعتباراً|تبدأ)\s+من\s+(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})/u', $this->annual_increase_rate, $dm)) {
            try {
                return Carbon::createFromDate((int) $dm[3], (int) $dm[2], (int) $dm[1])->startOfDay();
            } catch (\Throwable $e) {
                // Ignore parsing errors and fallback
            }
        }

        return $this->start_date ? Carbon::parse($this->start_date)->startOfDay()->addYear() : null;
    }

    /**
     * Calculate rent at a specific point in time
     */
    public function calculateRentAt(?Carbon $asOfDate = null): float
    {
        $asOfDate = $asOfDate ? $asOfDate->copy()->startOfDay() : Carbon::now()->startOfDay();
        $baseRent = (float) ($this->rent_amount ?? 0);

        if ($baseRent <= 0 || !$this->start_date) {
            return $baseRent;
        }

        $startDate = Carbon::parse($this->start_date)->startOfDay();
        $endDate = $this->end_date ? Carbon::parse($this->end_date)->startOfDay() : null;

        // Clamp to end_date if contract has already expired
        if ($endDate && $asOfDate->gt($endDate)) {
            $asOfDate = $endDate->copy();
        }

        // Before contract start
        if ($asOfDate->lt($startDate)) {
            return $baseRent;
        }

        $rates = $this->extractAnnualIncreaseRates();
        if (empty($rates)) {
            return $baseRent;
        }

        $incStartDate = $this->effective_annual_increase_start_date;
        if (!$incStartDate || $asOfDate->lt($incStartDate)) {
            return $baseRent;
        }

        $cycles = 1 + (int) $incStartDate->diffInYears($asOfDate);
        $currentRent = $baseRent;

        for ($i = 0; $i < $cycles; $i++) {
            $rule = $rates[$i] ?? end($rates);
            if ($rule['type'] === 'percent') {
                $currentRent = $currentRent * (1 + $rule['value']);
            } else {
                $currentRent += $rule['value'];
            }
        }

        return round($currentRent, 2);
    }

    /**
     * Get current actual monthly rent amount after annual increases
     */
    public function getCurrentRentAmountAttribute(): float
    {
        return $this->calculateRentAt();
    }

    /**
     * Get the monthly rent increase difference compared to base rent
     */
    public function getRentIncreaseDifferenceAttribute(): float
    {
        return round($this->current_rent_amount - (float) ($this->rent_amount ?? 0), 2);
    }

    /**
     * Check if the contract currently has an active rent increase
     */
    public function getHasRentIncreaseAttribute(): bool
    {
        return $this->rent_increase_difference > 0;
    }

    /**
     * Get the next upcoming annual increase date
     */
    public function getNextAnnualIncreaseDateAttribute(?Carbon $asOfDate = null): ?Carbon
    {
        if ($this->status !== 'active') {
            return null;
        }

        $rates = $this->extractAnnualIncreaseRates();
        if (empty($rates)) {
            return null;
        }

        $firstIncrease = $this->effective_annual_increase_start_date;
        if (!$firstIncrease) {
            return null;
        }

        $asOfDate = $asOfDate ? $asOfDate->copy()->startOfDay() : Carbon::now()->startOfDay();
        $firstIncrease = $firstIncrease->copy()->startOfDay();

        if ($asOfDate->lt($firstIncrease)) {
            $nextIncrease = $firstIncrease;
        } else {
            $years = (int) $firstIncrease->diffInYears($asOfDate);
            $candidate = $firstIncrease->copy()->addYears($years);
            if ($candidate->gt($asOfDate)) {
                $nextIncrease = $candidate;
            } else {
                $nextIncrease = $firstIncrease->copy()->addYears($years + 1);
            }
        }

        // If contract has ended or expires before next increase date, no further increase
        if ($this->end_date && $nextIncrease->gt(Carbon::parse($this->end_date)->startOfDay())) {
            return null;
        }

        return $nextIncrease;
    }

    /**
     * Get number of days until the next annual increase
     */
    public function getDaysUntilNextAnnualIncreaseAttribute(): ?int
    {
        $next = $this->next_annual_increase_date;
        if (!$next) {
            return null;
        }

        return Carbon::now()->startOfDay()->diffInDays($next, false);
    }

    /**
     * Check if annual increase is due within the next 30 days
     */
    public function getIsAnnualIncreaseDueSoonAttribute(): bool
    {
        $days = $this->days_until_next_annual_increase;
        return $days !== null && $days >= 0 && $days <= 30;
    }

    /**
     * Get expected rent amount after the next annual increase
     */
    public function getNextRentAmountAttribute(): ?float
    {
        $next = $this->next_annual_increase_date;
        if (!$next) {
            return null;
        }

        return $this->calculateRentAt($next);
    }

    /**
     * Get contract IDs that have an annual increase due within the specified number of days
     *
     * @return array<int>
     */
    public static function getIncreaseDueSoonIds(int $days = 30): array
    {
        $today = Carbon::now()->startOfDay();
        $ids = [];

        $contracts = static::where('status', 'active')
            ->whereNotNull('start_date')
            ->get();

        foreach ($contracts as $contract) {
            $rates = $contract->extractAnnualIncreaseRates();
            if (empty($rates)) {
                continue;
            }

            $firstIncrease = $contract->effective_annual_increase_start_date;
            if (!$firstIncrease) {
                continue;
            }

            $firstIncrease = $firstIncrease->copy()->startOfDay();

            if ($today->lt($firstIncrease)) {
                $nextIncrease = $firstIncrease;
            } else {
                $years = (int) $firstIncrease->diffInYears($today);
                $candidate = $firstIncrease->copy()->addYears($years);
                if ($candidate->gt($today)) {
                    $nextIncrease = $candidate;
                } else {
                    $nextIncrease = $firstIncrease->copy()->addYears($years + 1);
                }
            }

            if ($contract->end_date && $nextIncrease->gt(Carbon::parse($contract->end_date)->startOfDay())) {
                continue;
            }

            $diff = $today->diffInDays($nextIncrease, false);
            if ($diff >= 0 && $diff <= $days) {
                $ids[] = $contract->id;
            }
        }

        return $ids;
    }

    /**
     * Scope for contracts with annual increase due soon
     */
    public function scopeIncreaseDueSoon(Builder $query, int $days = 30): Builder
    {
        return $query->whereIn('id', static::getIncreaseDueSoonIds($days));
    }

    /**
     * Scope for active contracts
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now()->toDateString());
            });
    }

    /**
     * Scope for expired contracts
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('status', 'expired')
            ->orWhere(function ($q) {
                $q->whereNotNull('end_date')
                  ->where('end_date', '<', now()->toDateString());
            });
    }
}

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

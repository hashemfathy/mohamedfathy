<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ContractReportController extends Controller
{
    /**
     * Get structured report data
     */
    protected function getReportData(): array
    {
        Carbon::setLocale('ar');
        $today = Carbon::now();

        $project = Project::first();

        $totalContracts = Contract::count();
        $totalMonthlyRent = Contract::where('status', 'active')->get()->sum(fn ($c) => $c->current_rent_amount);
        $totalInsurance = Contract::sum('insurance_amount');

        $activeCount = Contract::where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>', now()->addDays(30)->toDateString());
            })->count();

        $endingSoonCount = Contract::where('status', 'active')
            ->whereBetween('end_date', [now()->toDateString(), now()->addDays(30)->toDateString()])
            ->count();

        $expiredCount = Contract::where('status', 'expired')
            ->orWhere(function ($q) {
                $q->whereNotNull('end_date')
                  ->where('end_date', '<', now()->toDateString());
            })->count();

        // Floor definitions
        $floorDefinitions = [
            [
                'display' => 'الدور الأرضي',
                'aliases' => ['الدور الأرضي', 'الارضى', 'الدور الارضى', 'الأرضي'],
            ],
            [
                'display' => 'الدور الأول علوي',
                'aliases' => ['الدور الأول', 'الدور الاول', 'الدور الأول علوي', 'الأول علوي'],
            ],
            [
                'display' => 'الدور الثاني علوي',
                'aliases' => ['الدور الثاني', 'الدور التاني', 'الدور الثاني علوي', 'الثاني علوي'],
            ],
            [
                'display' => 'الدور الثالث علوي',
                'aliases' => ['الدور الثالث', 'الدور التالت', 'الدور الثالث علوي', 'الثالث علوي'],
            ],
            [
                'display' => 'الدور الرابع علوي',
                'aliases' => ['الدور الرابع', 'الدور الرابع علوي', 'الرابع علوي'],
            ],
            [
                'display' => 'الدور الخامس علوي',
                'aliases' => ['الدور الخامس', 'الدور الخامس علوي', 'الخامس علوي'],
            ],
            [
                'display' => 'الدور السادس علوي',
                'aliases' => ['الدور السادس', 'الدور السادس علوي', 'السادس علوي'],
            ],
        ];

        $floorsData = [];
        $assignedIds = [];
        foreach ($floorDefinitions as $def) {
            $contracts = Contract::whereIn('floor', $def['aliases'])
                ->orderBy('unit_number')
                ->get();

            $assignedIds = array_merge($assignedIds, $contracts->pluck('id')->toArray());
            $floorRent = $contracts->where('status', 'active')->sum(fn ($c) => $c->current_rent_amount);

            $floorsData[] = [
                'name' => $def['display'],
                'contracts' => $contracts,
                'count' => $contracts->count(),
                'total_rent' => $floorRent,
            ];
        }

        // Add any contracts with unmapped floors if they exist
        $unmappedContracts = Contract::whereNotIn('id', $assignedIds)->get();
        if ($unmappedContracts->isNotEmpty()) {
            foreach ($unmappedContracts->groupBy('floor') as $unmappedFloor => $unmappedGroup) {
                $floorsData[] = [
                    'name' => $unmappedFloor ?: 'وحدات أخرى',
                    'contracts' => $unmappedGroup,
                    'count' => $unmappedGroup->count(),
                    'total_rent' => $unmappedGroup->where('status', 'active')->sum(fn ($c) => $c->current_rent_amount),
                ];
            }
        }

        // Arabic day name and date
        $days = [
            'Sunday' => 'الأحد',
            'Monday' => 'الإثنين',
            'Tuesday' => 'الثلاثاء',
            'Wednesday' => 'الأربعاء',
            'Thursday' => 'الخميس',
            'Friday' => 'الجمعة',
            'Saturday' => 'السبت',
        ];
        $months = [
            1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
            5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
            9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر',
        ];

        $dayName = $days[$today->format('l')] ?? '';
        $dateFormatted = "{$dayName}، {$today->day} " . ($months[$today->month] ?? '') . " {$today->year}";

        return [
            'project' => $project,
            'todayDate' => $dateFormatted,
            'totalContracts' => $totalContracts,
            'totalMonthlyRent' => $totalMonthlyRent,
            'totalInsurance' => $totalInsurance,
            'activeCount' => $activeCount,
            'endingSoonCount' => $endingSoonCount,
            'expiredCount' => $expiredCount,
            'floorsData' => $floorsData,
        ];
    }

    /**
     * Render the report HTML for viewing & browser printing
     */
    public function viewReport()
    {
        $data = $this->getReportData();
        return view('contracts.report', $data);
    }

    /**
     * Generate & Download PDF using Chrome headless
     */
    public function downloadPdf(): \Symfony\Component\HttpFoundation\Response
    {
        $data = $this->getReportData();
        $html = view('contracts.report', array_merge($data, ['isPdfExport' => true]))->render();

        $storageApp = storage_path('app');
        if (!File::exists($storageApp)) {
            File::makeDirectory($storageApp, 0755, true);
        }

        $tempHtmlPath = storage_path('app/temp_report_' . time() . '.html');
        $tempPdfPath = storage_path('app/تقرير_حصر_عقود_العقار_' . date('Y-m-d') . '.pdf');

        File::put($tempHtmlPath, $html);

        $chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
        if (!File::exists($chromePath)) {
            $chromePath = 'C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe';
        }

        $tempHtmlUrl = 'file:///' . str_replace('\\', '/', $tempHtmlPath);
        $tempProfile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'chrome_pdf_tmp_' . uniqid();

        // Run Chrome/Edge in headless mode with dedicated profile to prevent blocking on active browser instances
        $command = "powershell -NoProfile -Command \"& '{$chromePath}' --headless=new --disable-gpu --no-pdf-header-footer --user-data-dir='{$tempProfile}' --run-all-compositor-stages-before-draw --print-to-pdf='{$tempPdfPath}' '{$tempHtmlUrl}'\"";
        shell_exec($command);

        if (File::exists($tempHtmlPath)) {
            File::delete($tempHtmlPath);
        }

        if (File::exists($tempProfile)) {
            @File::deleteDirectory($tempProfile);
        }

        if (File::exists($tempPdfPath)) {
            return response()->download($tempPdfPath, 'تقرير_حصر_عقود_العقار_' . date('Y-m-d') . '.pdf', [
                'Content-Type' => 'application/pdf',
            ])->deleteFileAfterSend(true);
        }

        // Fallback: view report directly if PDF conversion failed
        return response()->redirectToRoute('contracts.report');
    }
}

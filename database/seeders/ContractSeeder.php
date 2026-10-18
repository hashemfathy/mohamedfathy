<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create or Find Mall Emaar Project
        $project = Project::firstOrCreate(
            ['name' => 'مول إعمار التجاري'],
            [
                'code' => 'EMAAR-140',
                'address' => '140 شارع الجيش – حي الافرنج – أول الإسماعيلية',
                'description' => 'مبنى تجاري وإداري - شركة إعمار للإستثمار والتنمية (ش.م.م)',
            ]
        );

        $jsonPath = storage_path('app/contracts_parsed.json');
        if (!File::exists($jsonPath)) {
            // Run python parser if json is missing
            $scriptPath = base_path('scripts/parse_contracts.py');
            if (File::exists($scriptPath)) {
                shell_exec("python " . escapeshellarg($scriptPath));
            }
        }

        if (!File::exists($jsonPath)) {
            $this->command?->warn("لم يتم العثور على ملف contracts_parsed.json");
            return;
        }

        $contractsData = json_decode(File::get($jsonPath), true);
        if (empty($contractsData)) {
            $this->command?->warn("بيانات العقود فارغة.");
            return;
        }

        // Clean previous test contracts
        Contract::query()->delete();

        $count = 0;
        foreach ($contractsData as $data) {
            $contractDate = $data['exec_date'] ?? null;
            $notes = "تم الاستيراد من ملف: {$data['file']}";
            if ($contractDate) {
                $notes .= " | تاريخ تحرير العقد (أنه في يوم): {$contractDate}";
            }

            Contract::create([
                'project_id' => $project->id,
                'floor' => $data['floor'],
                'unit_number' => $data['unit'],
                'tenant_name' => $data['tenant'],
                'tenant_national_id' => $data['national_id'] ?: null,
                'duration' => $data['duration'],
                'start_date' => $data['start_date'] ?: null,
                'end_date' => $data['end_date'] ?: null,
                'rent_amount' => $data['rent'] ?? 0,
                'insurance_amount' => $data['insurance'] ?? 0,
                'annual_increase_rate' => $data['increase'] ?? '10%',
                'service_fees' => $data['service_fees'] ?? 0,
                'status' => $data['status'] ?? 'active',
                'notes' => $notes,
                'file_path' => 'contracts_docs/' . $data['file'],
            ]);
            $count++;
        }

        $this->command?->info("✓ تم إدخال {$count} عقد معتمد بنجاح في قاعدة البيانات!");
    }
}

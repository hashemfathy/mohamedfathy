<?php

namespace App\Services;

use Carbon\Carbon;
use ZipArchive;

class WordContractParser
{
    /**
     * Extract plain text from a .docx file.
     */
    public function extractTextFromDocx(string $filePath): string
    {
        if (!file_exists($filePath)) {
            return '';
        }

        $zip = new ZipArchive();
        if ($zip->open($filePath) !== true) {
            return '';
        }

        $xmlContent = $zip->getFromName('word/document.xml');
        $zip->close();

        if (!$xmlContent) {
            return '';
        }

        // Replace end of paragraph and breaks with newlines
        $xmlContent = preg_replace('/<\/w:p>/', "\n", $xmlContent);
        $xmlContent = preg_replace('/<\/w:tr>/', "\n", $xmlContent);
        $xmlContent = preg_replace('/<\/w:tc>/', " | ", $xmlContent);

        // Strip all XML/HTML tags
        $cleanText = strip_tags($xmlContent);

        // Clean up excessive whitespace
        $lines = explode("\n", $cleanText);
        $filteredLines = array_filter(array_map('trim', $lines), fn ($line) => !empty($line));

        return implode("\n", $filteredLines);
    }

    /**
     * Parse structured contract data from text.
     */
    public function parseContractData(string $text, string $fileName = ''): array
    {
        $data = [
            'tenant_name' => $this->extractTenantName($text, $fileName),
            'project_name' => $this->extractProjectName($text),
            'floor' => $this->extractFloor($text),
            'unit_number' => $this->extractUnitNumber($text),
            'duration' => $this->extractDuration($text),
            'start_date' => $this->extractStartDate($text),
            'end_date' => $this->extractEndDate($text),
            'rent_amount' => $this->extractRentAmount($text),
            'insurance_amount' => $this->extractInsuranceAmount($text),
            'annual_increase_rate' => $this->extractAnnualIncrease($text),
            'annual_increase_start_date' => $this->extractAnnualIncreaseStartDate($text),
            'service_fees' => $this->extractServiceFees($text),
            'status' => 'active',
            'notes' => 'تم استيراده تلقائياً من ملف: ' . $fileName,
        ];

        // Determine active or expired status
        if ($data['end_date']) {
            $endDate = Carbon::parse($data['end_date']);
            $data['status'] = $endDate->isPast() ? 'expired' : 'active';
        }

        return $data;
    }

    protected function extractTenantName(string $text, string $fileName): string
    {
        // Try pattern: المستأجر / الطرف الثاني / السيد
        if (preg_match('/(?:الطرف الثاني|المستأجر|السيد\s*\/\s*السيد|المستأجر\s*[:\-])\s*[:\-]?\s*([^\n,،\-]+)/u', $text, $matches)) {
            $name = trim($matches[1]);
            if (mb_strlen($name) > 3) {
                return $name;
            }
        }

        // Fallback: extract from file name if named after tenant (e.g., "عقد محمد احمد.docx")
        $cleanFileName = pathinfo($fileName, PATHINFO_FILENAME);
        $cleanFileName = preg_replace('/^(عقد|ايجار|عقد ايجار)\s*/u', '', $cleanFileName);

        return !empty($cleanFileName) ? trim($cleanFileName) : 'مستأجر غير محدد';
    }

    protected function extractProjectName(string $text): string
    {
        if (preg_match('/(?:مشروع|برج|عمارة|مبنى|عقار)\s*[:\-]?\s*([^\n,،\-]+)/u', $text, $matches)) {
            return trim($matches[1]);
        }

        return 'المشروع الرئيسي';
    }

    protected function extractFloor(string $text): string
    {
        if (preg_match('/(?:الدور|الطابق|بالطابق|بالدور)\s*[:\-]?\s*([^\n,،\-]+)/u', $text, $matches)) {
            return trim($matches[1]);
        }

        return 'الدور الأرضي';
    }

    protected function extractUnitNumber(string $text): string
    {
        if (preg_match('/(?:الوحدة رقم|شقة رقم|محل رقم|رقم الوحدة|شقة|محل|وحدة)\s*[:\-]?\s*([0-9\/\-A-Za-z]+|[^\n,،\-]+)/u', $text, $matches)) {
            return trim($matches[1]);
        }

        return '1';
    }

    protected function extractDuration(string $text): ?string
    {
        if (preg_match('/(?:لمدة|مدة العقد|المدة هي|مدة الإيجار)\s*[:\-]?\s*([^\n,،\-]+)/u', $text, $matches)) {
            return trim($matches[1]);
        }

        return 'سنة ميلادية';
    }

    protected function extractStartDate(string $text): ?string
    {
        // Search for date patterns: YYYY-MM-DD or DD/MM/YYYY or DD-MM-YYYY
        if (preg_match('/(?:تبدأ من|اعتباراً من|من تاريخ|الموافق)\s*[:\-]?\s*(\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}|\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2})/u', $text, $matches)) {
            return $this->standardizeDate($matches[1]);
        }

        return null;
    }

    protected function extractEndDate(string $text): ?string
    {
        if (preg_match('/(?:تنتهي في|حتى تاريخ|إلى تاريخ|تنتهي بتاريخ)\s*[:\-]?\s*(\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}|\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2})/u', $text, $matches)) {
            return $this->standardizeDate($matches[1]);
        }

        return null;
    }

    protected function extractRentAmount(string $text): float
    {
        if (preg_match('/(?:القيمة الإيجارية|أجرة شهرية|الأجرة|الإيجار الشهري|مبلغ وقدره)\s*[:\-]?\s*([0-9,.]+)/u', $text, $matches)) {
            $cleaned = str_replace(',', '', $matches[1]);
            return (float) $cleaned;
        }

        return 0.0;
    }

    protected function extractInsuranceAmount(string $text): float
    {
        if (preg_match('/(?:تأمين قدره|مبلغ التأمين|التأمين)\s*[:\-]?\s*([0-9,.]+)/u', $text, $matches)) {
            $cleaned = str_replace(',', '', $matches[1]);
            return (float) $cleaned;
        }

        return 0.0;
    }

    protected function extractAnnualIncrease(string $text): ?string
    {
        if (preg_match('/(?:زيادة سنوية|نسبة الزيادة|بزيادة سنوية)\s*[:\-]?\s*([^\n,،]+)/u', $text, $matches)) {
            return trim($matches[1]);
        }

        return '10% سنوياً';
    }

    protected function extractAnnualIncreaseStartDate(string $text): ?string
    {
        if (preg_match('/(?:زيادة سنوية|نسبة الزيادة|بزيادة سنوية|الزيادة)[^.\n]*?(?:اعتبارا|اعتباراً|تبدأ)\s+من\s+(\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}|\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2})/u', $text, $matches)) {
            return $this->standardizeDate($matches[1]);
        }

        return null;
    }

    protected function extractServiceFees(string $text): float
    {
        if (preg_match('/(?:مقابل خدمات|خدمات وصيانة|رسوم خدمات)\s*[:\-]?\s*([0-9,.]+)/u', $text, $matches)) {
            $cleaned = str_replace(',', '', $matches[1]);
            return (float) $cleaned;
        }

        return 0.0;
    }

    protected function standardizeDate(string $rawDate): ?string
    {
        try {
            $rawDate = str_replace(['/', '.'], '-', trim($rawDate));
            return Carbon::parse($rawDate)->toDateString();
        } catch (\Throwable $e) {
            return null;
        }
    }
}

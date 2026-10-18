<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete()->comment('المشروع');
            $table->string('floor')->comment('رقم الدور في المبنى');
            $table->string('unit_number')->comment('رقم الوحدة / الشقة / المحل');
            $table->text('tenant_name')->comment('اسم المستأجر');
            $table->string('tenant_phone')->nullable()->comment('رقم هاتف المستأجر');
            $table->string('tenant_national_id')->nullable()->comment('الرقم القومي / السجل للمستأجر');
            $table->string('duration')->nullable()->comment('مدة العقد (مثال: سنة / سنتين)');
            $table->date('start_date')->nullable()->comment('تاريخ بدء العقد');
            $table->date('end_date')->nullable()->comment('تاريخ إنهاء العقد');
            $table->decimal('rent_amount', 12, 2)->default(0)->comment('القيمة الإيجارية');
            $table->decimal('insurance_amount', 12, 2)->default(0)->comment('مبلغ التأمين');
            $table->date('annual_increase_start_date')->nullable()->comment('تاريخ بدء الزيادة السنوية');
            $table->text('annual_increase_rate')->nullable()->comment('نسبة أو تفاصيل الزيادة السنوية');
            $table->decimal('service_fees', 12, 2)->default(0)->comment('مقابل الخدمات والصيانة');
            $table->enum('status', ['active', 'expired', 'terminated'])->default('active')->comment('حالة العقد: ساري أو منتهي أو مفسوخ');
            $table->text('notes')->nullable()->comment('ملاحظات إضافية أو شروط خاصة');
            $table->string('file_path')->nullable()->comment('ملف العقد Word أو PDF');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};

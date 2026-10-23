<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تقرير الحصر الشامل لعقود إيجار العقار - مكتب أ / محمد فتحي للمحاماة</title>

    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', 'Segoe UI', Tahoma, Arial, sans-serif;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            background-color: #f1f5f9;
            color: #0f172a;
            font-size: 13px;
            line-height: 1.5;
            padding-bottom: 40px;
        }

        /* Screen Control Bar (Hidden when printing) */
        .no-print-bar {
            background: #0f172a;
            color: #ffffff;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .no-print-bar .title {
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #e2b94c;
        }

        .no-print-bar .actions {
            display: flex;
            gap: 12px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .btn-print {
            background: #c59b27;
            color: #0f172a;
        }

        .btn-print:hover {
            background: #d8aa32;
        }

        .btn-download {
            background: #2563eb;
            color: #ffffff;
        }

        .btn-download:hover {
            background: #1d4ed8;
        }

        .btn-back {
            background: #334155;
            color: #f8fafc;
        }

        .btn-back:hover {
            background: #475569;
        }

        /* A4 Report Sheet Container */
        .report-wrapper {
            max-width: 1050px;
            margin: 24px auto;
            background: #ffffff;
            padding: 32px 36px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-radius: 4px;
        }

        /* Header Section */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
            gap: 20px;
        }

        .header-title-area h1 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .header-title-area h2 {
            font-size: 15px;
            font-weight: 700;
            color: #9a5b13;
            margin-bottom: 4px;
        }

        .header-title-area p {
            font-size: 12px;
            color: #64748b;
        }

        .header-meta-box {
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            border-radius: 6px;
            padding: 8px 14px;
            font-size: 11px;
            line-height: 1.6;
            min-width: 250px;
            color: #334155;
        }

        .header-meta-box div {
            display: flex;
            justify-content: space-between;
            gap: 8px;
        }

        .header-meta-box strong {
            color: #0f172a;
            font-weight: 600;
        }

        /* Dual Divider */
        .header-divider {
            margin-bottom: 20px;
        }

        .header-divider .line-gold {
            height: 2px;
            background: #c59b27;
            margin-bottom: 2px;
        }

        .header-divider .line-dark {
            height: 1px;
            background: #183b56;
        }

        /* Top 4 KPI Cards */
        .summary-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .kpi-card {
            border: 1px solid #cbd5e1;
            border-top: 3px solid #0284c7;
            border-radius: 6px;
            padding: 12px 10px;
            text-align: center;
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        .kpi-card .label {
            font-size: 11px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .kpi-card .value {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        .status-pill-group {
            font-size: 12px;
            font-weight: 700;
        }

        .status-pill-group .s-active {
            color: #16a34a;
        }

        .status-pill-group .s-soon {
            color: #d97706;
        }

        .status-pill-group .s-expired {
            color: #dc2626;
        }

        /* Floor Group Section */
        .floor-section {
            margin-bottom: 20px;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .floor-header-bar {
            background: #183b56;
            color: #ffffff;
            padding: 8px 14px;
            border-radius: 4px 4px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            font-size: 13px;
        }

        .floor-header-bar .floor-name {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .floor-header-bar .floor-rent {
            font-size: 12px;
            background: rgba(255, 255, 255, 0.15);
            padding: 2px 10px;
            border-radius: 4px;
            font-weight: 600;
        }

        /* Notice Box for Empty Floors */
        .empty-floor-box {
            border: 1px solid #e2e8f0;
            border-top: none;
            background: #ffffff;
            padding: 18px 20px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
            border-radius: 0 0 4px 4px;
        }

        .empty-floor-box span {
            color: #d97706;
            font-weight: 600;
        }

        /* Contracts Data Table */
        .contracts-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            border: 1px solid #cbd5e1;
            border-top: none;
            border-radius: 0 0 4px 4px;
            overflow: hidden;
        }

        .contracts-table th {
            background: #f1f5f9;
            color: #1e293b;
            font-weight: 700;
            padding: 8px 6px;
            text-align: center;
            border: 1px solid #cbd5e1;
            white-space: nowrap;
        }

        .contracts-table td {
            padding: 8px 6px;
            text-align: center;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            vertical-align: middle;
        }

        .contracts-table tr:nth-child(even) {
            background: #fafafa;
        }

        /* Specific Table Columns */
        .col-unit {
            font-weight: 700;
            color: #0f172a;
            white-space: nowrap;
        }

        .col-tenant {
            text-align: right !important;
            padding-right: 8px !important;
        }

        .col-tenant .name {
            font-weight: 700;
            color: #0f172a;
            font-size: 11.5px;
        }

        .col-tenant .sub-info {
            font-size: 10px;
            color: #64748b;
            display: flex;
            flex-direction: column;
            gap: 1px;
            margin-top: 2px;
        }

        .col-money {
            font-weight: 700;
            white-space: nowrap;
            color: #0f172a;
        }

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-active {
            color: #15803d;
            background: #f0fdf4;
            border: 1px solid #86efac;
        }

        .badge-expired {
            color: #b91c1c;
            background: #fef2f2;
            border: 1px solid #fca5a5;
        }

        .badge-soon {
            color: #b45309;
            background: #fffbeb;
            border: 1px solid #fde68a;
        }

        /* Legal Disclaimers & Signatures Box */
        .report-legal-footer {
            margin-top: 30px;
            border: 1px dashed #94a3b8;
            border-radius: 6px;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            background: #fafafa;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .legal-notes h4 {
            font-size: 12.5px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .legal-notes ol {
            padding-right: 18px;
            font-size: 11px;
            color: #475569;
            line-height: 1.7;
        }

        .legal-signature-box {
            border: 1px solid #cbd5e1;
            background: #ffffff;
            border-radius: 6px;
            padding: 12px 18px;
            text-align: center;
            min-width: 260px;
        }

        .legal-signature-box .auth-title {
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
        }

        .legal-signature-box .auth-name {
            font-size: 11.5px;
            color: #334155;
            margin-bottom: 8px;
        }

        .legal-signature-box .stamp-box {
            font-size: 11px;
            color: #94a3b8;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px dashed #cbd5e1;
            border-radius: 4px;
            background: #f8fafc;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .no-print-bar {
                display: none !important;
            }

            .report-wrapper {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 10mm 10mm !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            .floor-section {
                page-break-inside: auto;
                break-inside: auto;
                margin-bottom: 16px;
            }

            .floor-header-bar {
                page-break-after: avoid;
                break-after: avoid;
            }

            .contracts-table {
                page-break-inside: auto;
                break-inside: auto;
            }

            .contracts-table thead {
                display: table-header-group;
            }

            .contracts-table tr {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            .report-legal-footer {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            @page {
                size: A4 portrait;
                margin: 8mm 6mm;
            }
        }
    </style>
</head>
<body>

    @if (!isset($isPdfExport) || !$isPdfExport)
    <!-- Top Action Control Bar -->
    <div class="no-print-bar">
        <div class="title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
            معاينة تقرير حصر عقود العقار - مكتب أ / محمد فتحي
        </div>
        <div class="actions">
            <button onclick="window.print()" class="btn-action btn-print">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 6 2 18 2 18 9"/>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                    <rect width="12" height="8" x="6" y="14"/>
                </svg>
                طباعة التقرير / حفظ كـ PDF
            </button>

            <a href="{{ route('contracts.report.download') }}" class="btn-action btn-download">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                تحميل PDF مباشر
            </a>

            <a href="{{ url('/admin/contracts') }}" class="btn-action btn-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                العودة للوحة الإدارة
            </a>
        </div>
    </div>
    @endif

    <!-- Printable Report Container -->
    <div class="report-wrapper">

        <!-- Header -->
        <div class="report-header">
            <div class="header-title-area">
                <h1>مكتب أ / محمد فتحي للمحاماة والاستشارات القانونية</h1>
                <h2>تقرير الحصر الشامل والملخص التنفيذي لعقود إيجار العقار</h2>
                <p>حصر تفصيلي شامل لعقود إيجار وحدات العقار (من الدور الأرضي 0 حتى الدور السادس علوي 6)</p>
            </div>

            <div class="header-meta-box">
                <div><span>تاريخ إعداد التقرير:</span> <strong>{{ $todayDate }}</strong></div>
                <div><span>النظام القانوني:</span> <strong>القانون رقم 4 لسنة 1996</strong></div>
                <div><span>نطاق العقار:</span> <strong>الأدوار من (0) إلى (6) علوي</strong></div>
            </div>
        </div>

        <!-- Double Divider Line -->
        <div class="header-divider">
            <div class="line-gold"></div>
            <div class="line-dark"></div>
        </div>

        <!-- 4 KPI Summary Cards -->
        <div class="summary-cards-grid">
            <div class="kpi-card">
                <div class="label">إجمالي الوحدات والعقود</div>
                <div class="value">{{ $totalContracts }} وحدة</div>
            </div>

            <div class="kpi-card">
                <div class="label">إجمالي الدخل الإيجاري الشهري</div>
                <div class="value">{{ number_format($totalMonthlyRent, 0) }} ج.م</div>
            </div>

            <div class="kpi-card">
                <div class="label">إجمالي مبالغ التأمين</div>
                <div class="value">{{ number_format($totalInsurance, 0) }} ج.م</div>
            </div>

            <div class="kpi-card">
                <div class="label">حالة العقود</div>
                <div class="value status-pill-group">
                    <span class="s-active">{{ $activeCount }} سارٍ</span> |
                    <span class="s-soon">{{ $endingSoonCount }} قريباً</span> |
                    <span class="s-expired">{{ $expiredCount }} منتهٍ</span>
                </div>
            </div>
        </div>

        <!-- Floor by Floor Sections -->
        @foreach ($floorsData as $floor)
            <div class="floor-section">
                <!-- Floor Header -->
                <div class="floor-header-bar">
                    <div class="floor-name">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="16" height="20" x="4" y="2" rx="2" ry="2"/>
                            <path d="M9 22v-4h6v4"/>
                            <path d="M8 6h.01"/>
                            <path d="M16 6h.01"/>
                            <path d="M8 10h.01"/>
                            <path d="M16 10h.01"/>
                            <path d="M8 14h.01"/>
                            <path d="M16 14h.01"/>
                        </svg>
                        {{ $floor['name'] }} ({{ $floor['count'] }} عقود)
                    </div>
                    <div class="floor-rent">
                        إجمالي الإيجار: {{ number_format($floor['total_rent'], 0) }} ج.م / شهر
                    </div>
                </div>

                @if ($floor['count'] == 0)
                    <!-- Empty Notice -->
                    <div class="empty-floor-box">
                        <span>📁 لا توجد عقود مسجلة حالياً في مجلد ({{ $floor['name'] }}).</span>
                    </div>
                @else
                    <!-- Contracts Table -->
                    <table class="contracts-table">
                        <thead>
                            <tr>
                                <th style="width: 14%;">رقم الوحدة والدور</th>
                                <th style="width: 25%;">اسم المستأجر وبياناته</th>
                                <th style="width: 10%;">مدة العقد</th>
                                <th style="width: 10%;">تاريخ البدء</th>
                                <th style="width: 10%;">تاريخ الانتهاء</th>
                                <th style="width: 11%;">القيمة الإيجارية الحالية</th>
                                <th style="width: 9%;">مبلغ التأمين</th>
                                <th style="width: 11%;">الزيادة السنوية تبدأ من</th>
                                <th style="width: 8%;">الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($floor['contracts'] as $contract)
                                @php
                                    $isExpired = $contract->is_expired;
                                    $isEndingSoon = false;
                                    if (!$isExpired && $contract->end_date) {
                                        $endDate = \Carbon\Carbon::parse($contract->end_date);
                                        $isEndingSoon = $endDate->isFuture() && $endDate->diffInDays(now()) <= 30;
                                    }

                                    $inc = trim($contract->annual_increase_rate ?? '');
                                    if (empty($inc) || str_contains($inc, 'بدون') || str_contains($inc, 'لا يوجد')) {
                                        $incDisplay = 'بدون زيادة سنوية';
                                    } elseif (preg_match('/(\d+[\.,]?\d*\s*\%)/', $inc, $matches)) {
                                        $incDisplay = $matches[1] . ' سنوياً';
                                    } else {
                                        $incDisplay = \Illuminate\Support\Str::limit($inc, 25);
                                    }
                                @endphp
                                <tr>
                                    <td class="col-unit">
                                        {{ $contract->unit_number }}
                                        <div style="font-size: 10px; color: #64748b; font-weight: normal;">{{ $floor['name'] }}</div>
                                    </td>
                                    <td class="col-tenant">
                                        <div class="name">{{ $contract->tenant_name }}</div>
                                        <div class="sub-info">
                                            @if ($contract->tenant_phone)
                                                <span>هاتف: {{ $contract->tenant_phone }}</span>
                                            @endif
                                            @if ($contract->tenant_national_id)
                                                <span>ر.ق: {{ $contract->tenant_national_id }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $contract->duration ?? 'سنة' }}</td>
                                    <td>{{ $contract->start_date ? $contract->start_date->format('Y-m-d') : '—' }}</td>
                                    <td>{{ $contract->end_date ? $contract->end_date->format('Y-m-d') : '—' }}</td>
                                    <td class="col-money">
                                        {{ number_format($contract->current_rent_amount, 0) }} ج.م
                                        @if ($contract->has_rent_increase)
                                            <div style="font-size: 10px; color: #16a34a; font-weight: normal;">(ابتدائي: {{ number_format($contract->rent_amount, 0) }})</div>
                                        @endif
                                    </td>
                                    <td class="col-money">{{ number_format($contract->insurance_amount, 0) }} ج.م</td>
                                    <td>{{ $incDisplay }}</td>
                                    <td>
                                        @if ($isExpired)
                                            <span class="badge badge-expired">منتهي</span>
                                        @elseif ($isEndingSoon)
                                            <span class="badge badge-soon">قريباً</span>
                                        @else
                                            <span class="badge badge-active">ساري</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @endforeach

        <!-- Legal Disclaimers & Signatures Footer -->
        <div class="report-legal-footer">
            <div class="legal-notes">
                <h4>إقرار وتنبيهات قانونية:</h4>
                <ol>
                    <li>تم استخراج هذا البيان بناءً على العقود والمستندات المحفوظة بمجلدات العقار من الدور (0) حتى (6).</li>
                    <li>يُراعى توجيه الإنذارات القانونية للمستأجرين قبل انتهاء العقد بشهرين على الأقل وفقاً لنصوص القانون 4 لسنة 1996.</li>
                    <li>تُحسب وتُحصل الزيادات السنوية في المواعيد المقررة بعاليه.</li>
                </ol>
            </div>

            <div class="legal-signature-box">
                <div class="auth-title">اعتماد الأستاذ / محمد فتحي (المحامي)</div>
                <div class="auth-name">الاسم والتوقيع: أ/ محمد فتحي</div>
                <div class="stamp-box">خاتم أ/ محمد فتحي: [ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ]</div>
            </div>
        </div>

    </div>

</body>
</html>

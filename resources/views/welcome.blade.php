<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>مكتب الأستاذ محمد فتحي | نظام إدارة العقود والأملاك</title>

    <!-- Google Fonts: Cairo & Amiri -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #0b0f19;
            --bg-card: #111827;
            --bg-card-hover: #162032;
            --primary-gold: #c59b27;
            --primary-gold-hover: #d8aa32;
            --gold-glow: rgba(197, 155, 39, 0.25);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-gold: rgba(197, 155, 39, 0.3);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-gold: #e2b94c;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Background Glow */
        .ambient-glow {
            position: absolute;
            top: -120px;
            right: 10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(197, 155, 39, 0.15) 0%, rgba(11, 15, 25, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        .ambient-glow-2 {
            position: absolute;
            bottom: 5%;
            left: 5%;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(30, 58, 138, 0.15) 0%, rgba(11, 15, 25, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        /* Top Navigation Header */
        header {
            position: relative;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            border-bottom: 1px solid var(--border-color);
            background: rgba(11, 15, 25, 0.7);
            backdrop-filter: blur(12px);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            text-decoration: none;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border: 1px solid var(--border-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-gold);
            box-shadow: 0 4px 15px var(--gold-glow);
        }

        .brand-text h1 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        .brand-text p {
            font-size: 0.78rem;
            color: var(--text-gold);
            font-weight: 500;
        }

        .btn-header-login {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.4rem;
            border-radius: 8px;
            background: transparent;
            color: var(--text-main);
            border: 1px solid var(--border-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.25s ease;
        }

        .btn-header-login:hover {
            border-color: var(--primary-gold);
            color: var(--primary-gold);
            background: rgba(197, 155, 39, 0.05);
        }

        /* Hero Main Section */
        main {
            position: relative;
            z-index: 10;
            flex: 1;
            display: flex;
            align-items: center;
            padding: 3rem 5%;
            max-width: 1300px;
            margin: 0 auto;
            width: 100%;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.95fr;
            gap: 4rem;
            align-items: center;
            width: 100%;
        }

        .hero-content {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            background: rgba(197, 155, 39, 0.1);
            border: 1px solid var(--border-gold);
            color: var(--text-gold);
            font-size: 0.85rem;
            font-weight: 600;
            width: fit-content;
        }

        .badge-pill svg {
            width: 16px;
            height: 16px;
        }

        .hero-title {
            font-size: 2.75rem;
            font-weight: 800;
            line-height: 1.25;
            color: #ffffff;
            font-family: 'Cairo', sans-serif;
        }

        .hero-title span {
            background: linear-gradient(135deg, #e2b94c 0%, #ffffff 80%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-description {
            font-size: 1.05rem;
            line-height: 1.8;
            color: var(--text-muted);
            max-width: 580px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            margin-top: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-primary-admin {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 0.95rem 2rem;
            border-radius: 10px;
            background: linear-gradient(135deg, #c59b27, #dfb43b);
            color: #0b0f19;
            text-decoration: none;
            font-size: 1.05rem;
            font-weight: 700;
            box-shadow: 0 10px 25px rgba(197, 155, 39, 0.35);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-primary-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(197, 155, 39, 0.5);
            background: linear-gradient(135deg, #d8aa32, #ecc34e);
        }

        .btn-primary-admin svg {
            width: 20px;
            height: 20px;
            transition: transform 0.25s ease;
        }

        .btn-primary-admin:hover svg {
            transform: scale(1.1);
        }

        /* Stats Row */
        .quick-stats {
            display: flex;
            gap: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
            margin-top: 1rem;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .stat-value {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--text-gold);
        }

        .stat-label {
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        /* Hero Image Container */
        .hero-media {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-frame {
            position: relative;
            border-radius: 20px;
            padding: 8px;
            background: linear-gradient(145deg, rgba(197, 155, 39, 0.4), rgba(255, 255, 255, 0.05), rgba(197, 155, 39, 0.15));
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), 0 0 40px var(--gold-glow);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            width: 100%;
            max-width: 520px;
        }

        .image-frame:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7), 0 0 55px rgba(197, 155, 39, 0.35);
        }

        .image-frame img {
            width: 100%;
            height: auto;
            border-radius: 14px;
            display: block;
            object-fit: cover;
            aspect-ratio: 16 / 10.5;
            filter: contrast(1.05) brightness(0.98);
        }

        .floating-tag {
            position: absolute;
            bottom: -15px;
            right: 25px;
            background: rgba(17, 24, 39, 0.92);
            border: 1px solid var(--border-gold);
            padding: 0.65rem 1.25rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            color: var(--text-main);
            font-size: 0.88rem;
            font-weight: 600;
        }

        .floating-tag .tag-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #22c55e;
            box-shadow: 0 0 10px #22c55e;
        }

        /* Features Section */
        .features-section {
            position: relative;
            z-index: 10;
            padding: 3rem 5% 5rem;
            max-width: 1300px;
            margin: 0 auto;
            width: 100%;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.75rem;
        }

        .feature-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-gold), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            background: var(--bg-card-hover);
            border-color: var(--border-gold);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(197, 155, 39, 0.1);
            color: var(--primary-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            border: 1px solid rgba(197, 155, 39, 0.2);
        }

        .feature-icon svg {
            width: 24px;
            height: 24px;
        }

        .feature-card h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.65rem;
        }

        .feature-card p {
            font-size: 0.92rem;
            color: var(--text-muted);
            line-height: 1.65;
        }

        /* Footer */
        footer {
            position: relative;
            z-index: 10;
            margin-top: auto;
            border-top: 1px solid var(--border-color);
            padding: 1.75rem 5%;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
            background: rgba(11, 15, 25, 0.8);
        }

        footer span {
            color: var(--text-gold);
            font-weight: 600;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 3rem;
                text-align: center;
            }

            .hero-content {
                align-items: center;
            }

            .badge-pill {
                margin: 0 auto;
            }

            .hero-title {
                font-size: 2.2rem;
            }

            .hero-actions {
                justify-content: center;
            }

            .quick-stats {
                justify-content: center;
            }

            .image-frame {
                max-width: 440px;
            }
        }

        @media (max-width: 600px) {
            .hero-title {
                font-size: 1.85rem;
            }

            .quick-stats {
                gap: 1.25rem;
            }

            .stat-value {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="ambient-glow"></div>
    <div class="ambient-glow-2"></div>

    <!-- Navigation Header -->
    <header>
        <a href="/" class="brand">
            <div class="brand-icon">
                <!-- Scale of Justice Icon -->
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="22" height="22">
                    <path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/>
                    <path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/>
                    <path d="M7 21h10"/>
                    <path d="M12 3v18"/>
                    <path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/>
                </svg>
            </div>
            <div class="brand-text">
                <h1>مكتب الأستاذ محمد فتحي</h1>
                <p>للمحاماة والاستشارات القانونية وإدارة الأملاك</p>
            </div>
        </a>

        <div>
            @auth
                <a href="{{ url('/admin') }}" class="btn-header-login">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="3" rx="2"/>
                        <path d="M9 3v18"/>
                    </svg>
                    لوحة التحكم
                </a>
            @else
                <a href="{{ route('filament.admin.auth.login', absolute: false) }}" class="btn-header-login">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    دخول الإدارة
                </a>
            @endauth
        </div>
    </header>

    <!-- Hero Content -->
    <main>
        <div class="hero-grid">
            <div class="hero-content">
                <div class="badge-pill">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    منظومة التوثيق والمتابعة القانونية
                </div>

                <h2 class="hero-title">
                    إدارة العقود والأملاك<br>
                    <span>بدقة واحترافية قانونية</span>
                </h2>

                <p class="hero-description">
                    بوابة رقمية متكاملة مخصصة لمكتب الأستاذ محمد فتحي للمحاماة لإدارة وأرشفة عقود الإيجار، وتتبع سريان الوحدات والمحلات والمكاتب، وحساب المستحقات المالية والزيادات السنوية بكل دقة.
                </p>

                <div class="hero-actions">
                    @auth
                        <a href="{{ url('/admin') }}" class="btn-primary-admin">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="18" x="3" y="3" rx="2"/>
                                <path d="M9 3v18"/>
                                <path d="m14 9 3 3-3 3"/>
                            </svg>
                            الانتقال إلى لوحة التحكم
                        </a>
                    @else
                        <a href="{{ route('filament.admin.auth.login', absolute: false) }}" class="btn-primary-admin">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="18" x="3" y="3" rx="2"/>
                                <path d="M9 3v18"/>
                                <path d="m14 9 3 3-3 3"/>
                            </svg>
                            تسجيل دخول الأدمن (لوحة التحكم)
                        </a>
                    @endauth
                </div>

            </div>

            <!-- Hero Image Display -->
            <div class="hero-media">
                <div class="image-frame">
                    <img src="{{ asset('images/justice.png') }}" alt="ميزان العدالة والقانون">
                    <div class="floating-tag">
                        <span class="tag-dot"></span>
                        <span>النظام نشط ومحدث قانونياً</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Feature Highlights -->
    <section class="features-section">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                </div>
                <h3>أرشفة وتوثيق العقود</h3>
                <p>قاعدة بيانات مركزية تربط كل عقد بالوحدة المستأجرة، الدور في المبنى، مع حفظ بيانات المستأجر والشروط الخاصة والمرفقات الأصلية.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <h3>متابعة السريان والتنبيهات</h3>
                <p>تحديد فوري لحالة العقود (سارية أو منتهية) مع فلاتر ذكية ترصد العقود التي تقترب من الانتهاء خلال 30 يوماً لاتخاذ الإجراءات القانونية في موعدها.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                <h3>إدارة الالتزامات المالية</h3>
                <p>تسجيل القيمة الإيجارية الشهرية، مبالغ التأمين، مقابل الصيانة والخدمات، وجدولة نسبة وتاريخ بدء تطبيق الزيادات السنوية بدقة متناهية.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>© {{ date('Y') }} <span>مكتب الأستاذ محمد فتحي للمحاماة والاستشارات</span> - جميع الحقوق محفوظة</p>
    </footer>
</body>
</html>

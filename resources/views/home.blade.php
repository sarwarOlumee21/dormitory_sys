@extends('layouts.generalLayouts')

@section('content')

<div class="row" style="direction: rtl; text-align: right;">
    <div class="col-12">

        {{-- استایل‌های اختصاصی و حرفه‌ای پیشخوان --}}
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap');

            :root {
                --primary: #3b82f6;
                --primary-hover: #2563eb;
                --bg-card: #ffffff;
                --text-main: #0f172a;
                --text-muted: #64748b;
                --border-color: #f1f5f9;
                
                --color-primary: #4f46e5;
                --color-success: #10b981;
                --color-info: #0ea5e9;
                --color-warning: #f59e0b;
                --color-purple: #8b5cf6;
                --color-danger: #ef4444;
            }

            body {
                font-family: 'Vazirmatn', sans-serif !important;
                background-color: #f8fafc;
            }

            /* استایل‌های بنر اصلی (دقیقاً مطابق نسخه شما) */
            .dashboard-banner {
                background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
                border-radius: 16px;
                padding: 24px 28px;
                color: #ffffff;
                box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.3);
            }

            .banner-icon-wrapper {
                background: rgba(255, 255, 255, 0.15);
                width: 52px;
                height: 52px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                backdrop-filter: blur(8px);
            }

            /* --- Stat Cards (کارت‌های آمار مدرن) --- */
            .stat-card-link {
                text-decoration: none !important;
                display: block;
                height: 100%;
            }

            .stat-card-custom {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 18px !important;
                padding: 20px !important;
                transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
            }

            .stat-card-custom::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 100%;
                height: 4px;
                background: transparent;
                transition: background 0.3s ease;
            }

            .stat-card-custom:hover {
                transform: translateY(-6px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
                border-color: transparent !important;
            }

            .theme-primary:hover::before { background: var(--color-primary); }
            .theme-success:hover::before { background: var(--color-success); }
            .theme-info:hover::before { background: var(--color-info); }
            .theme-warning:hover::before { background: var(--color-warning); }
            .theme-purple:hover::before { background: var(--color-purple); }
            .theme-danger:hover::before { background: var(--color-danger); }

            .stat-icon-box {
                width: 48px;
                height: 48px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
                transition: transform 0.3s ease;
            }

            .stat-card-custom:hover .stat-icon-box {
                transform: scale(1.1) rotate(-4deg);
            }

            .stat-value {
                font-size: 26px;
                font-weight: 800;
                letter-spacing: -0.5px;
                color: var(--text-main);
            }

            .custom-progress {
                height: 6px !important;
                border-radius: 10px !important;
                background-color: #f1f5f9;
                overflow: hidden;
            }

            /* --- Custom Dashboard Cards --- */
            .custom-dashboard-card {
                background: var(--bg-card);
                border: 1px solid #e2e8f0 !important;
                border-radius: 20px !important;
                box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
                overflow: hidden;
            }

            .custom-dashboard-card .card-header {
                background: #ffffff;
                border-bottom: 1px solid #f1f5f9;
                padding: 20px 24px;
                font-weight: 700;
                color: var(--text-main);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            /* --- Quick Action Buttons --- */
            .btn-quick-action {
                border-radius: 14px !important;
                font-size: 13.5px;
                font-weight: 600;
                padding: 16px 18px;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                gap: 12px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border: 1px solid transparent;
                text-decoration: none !important;
            }

            .btn-quick-action i {
                font-size: 22px;
                transition: transform 0.3s ease;
            }

            .btn-quick-action:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.06);
            }

            .btn-quick-action:hover i {
                transform: scale(1.15);
            }

            .btn-quick-primary { background: rgba(79, 70, 229, 0.08); color: var(--color-primary); }
            .btn-quick-primary:hover { background: var(--color-primary); color: #ffffff; }

            .btn-quick-success { background: rgba(16, 185, 129, 0.08); color: var(--color-success); }
            .btn-quick-success:hover { background: var(--color-success); color: #ffffff; }

            .btn-quick-info { background: rgba(14, 165, 233, 0.08); color: var(--color-info); }
            .btn-quick-info:hover { background: var(--color-info); color: #ffffff; }

            .btn-quick-purple { background: rgba(139, 92, 246, 0.08); color: var(--color-purple); }
            .btn-quick-purple:hover { background: var(--color-purple); color: #ffffff; }

            .btn-quick-warning { background: rgba(245, 158, 11, 0.08); color: var(--color-warning); }
            .btn-quick-warning:hover { background: var(--color-warning); color: #ffffff; }

            .btn-quick-danger { background: rgba(239, 68, 68, 0.08); color: var(--color-danger); }
            .btn-quick-danger:hover { background: var(--color-danger); color: #ffffff; }

            /* --- Timeline Activity Stream --- */
            .activity-stream {
                position: relative;
                padding-right: 12px;
            }

            .activity-stream::before {
                content: '';
                position: absolute;
                right: 17px;
                top: 10px;
                bottom: 10px;
                width: 2px;
                background: #f1f5f9;
            }

            .activity-item-modern {
                position: relative;
                padding-right: 28px;
                padding-bottom: 20px;
            }

            .activity-item-modern:last-child {
                padding-bottom: 0;
            }

            .activity-dot {
                position: absolute;
                right: -17px;
                top: 4px;
                width: 12px;
                height: 12px;
                border-radius: 50%;
                background: #fff;
                border: 3px solid var(--primary);
                z-index: 2;
            }

            .alert-demo-custom {
                background: linear-gradient(135deg, #eff6ff 0%, #e0e7ff 100%);
                color: #1e40af;
                border: 1px solid #bfdbfe;
                border-radius: 16px;
            }
        </style>

        {{-- ۱. بنر خوش‌آمدگویی بالا (دقیقاً بدون تغییر) --}}
        <div class="dashboard-banner mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="banner-icon-wrapper ml-3">
                        <i class="la la-bolt text-white" style="font-size:26px;"></i>
                    </div>
                    <div>
                        <h4 class="text-white mb-1 font-weight-bold">پیشخوان مدیریت خوابگاه</h4>
                        <p class="mb-0" style="color: rgba(255,255,255,0.85); font-size:13px;">
                            خلاصه وضعیت کلی، دسترسی سریع و آخرین رویدادهای سیستم
                        </p>
                    </div>
                </div>
                <div>
                    <span class="badge bg-white text-primary px-3 py-2" style="border-radius: 8px; font-size: 12px; font-weight: 600;">
                        <i class="la la-calendar ml-1"></i> امروز: {{ date('Y/m/d') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ۲. کارت‌های شش‌گانه آمار پیشرفته --}}
        <div class="row g-3 mb-4">
            {{-- ساکنین --}}
            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-3">
                <a href="{{ route('resident.list') }}" class="stat-card-link">
                    <div class="card stat-card-custom theme-primary">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted font-small-3 font-weight-600">ساکنین</span>
                            <div class="stat-icon-box" style="background: rgba(79, 70, 229, 0.1); color: var(--color-primary);">
                                <i class="la la-users"></i>
                            </div>
                        </div>
                        <div class="stat-value mb-1">۴۸</div>
                        <div class="progress custom-progress mb-2">
                            <div class="progress-bar" style="width: 80%; background-color: var(--color-primary);"></div>
                        </div>
                        <small class="text-success font-weight-600 font-small-2 d-flex align-items-center gap-1">
                            <i class="la la-arrow-up"></i> ۱۲٪ رشد ماهانه
                        </small>
                    </div>
                </a>
            </div>

            {{-- اتاق‌ها --}}
            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-3">
                <a href="#" class="stat-card-link">
                    <div class="card stat-card-custom theme-success">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted font-small-3 font-weight-600">کل اتاق‌ها</span>
                            <div class="stat-icon-box" style="background: rgba(16, 185, 129, 0.1); color: var(--color-success);">
                                <i class="la la-home"></i>
                            </div>
                        </div>
                        <div class="stat-value mb-1">۲۴</div>
                        <div class="progress custom-progress mb-2">
                            <div class="progress-bar" style="width: 66%; background-color: var(--color-success);"></div>
                        </div>
                        <small class="text-muted font-weight-600 font-small-2">۸ اتاق خالی باقی‌مانده</small>
                    </div>
                </a>
            </div>

            {{-- قراردادها --}}
            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-3">
                <a href="#" class="stat-card-link">
                    <div class="card stat-card-custom theme-info">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted font-small-3 font-weight-600">قرارداد فعال</span>
                            <div class="stat-icon-box" style="background: rgba(14, 165, 233, 0.1); color: var(--color-info);">
                                <i class="la la-file-text"></i>
                            </div>
                        </div>
                        <div class="stat-value mb-1">۴۵</div>
                        <div class="progress custom-progress mb-2">
                            <div class="progress-bar" style="width: 75%; background-color: var(--color-info);"></div>
                        </div>
                        <small class="text-muted font-weight-600 font-small-2">درآمد: ۱۲۵M افغانی</small>
                    </div>
                </a>
            </div>

            {{-- پرداخت معوق --}}
            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-3">
                <a href="#" class="stat-card-link">
                    <div class="card stat-card-custom theme-warning">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted font-small-3 font-weight-600">معوقات</span>
                            <div class="stat-icon-box" style="background: rgba(245, 158, 11, 0.1); color: var(--color-warning);">
                                <i class="la la-money"></i>
                            </div>
                        </div>
                        <div class="stat-value mb-1" style="color: var(--color-warning);">۳</div>
                        <div class="progress custom-progress mb-2">
                            <div class="progress-bar" style="width: 30%; background-color: var(--color-warning);"></div>
                        </div>
                        <small class="text-danger font-weight-600 font-small-2">۴.۵M افغانی بدهی</small>
                    </div>
                </a>
            </div>

            {{-- مهمانان --}}
            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-3">
                <a href="#" class="stat-card-link">
                    <div class="card stat-card-custom theme-purple">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted font-small-3 font-weight-600">مهمانان داخل</span>
                            <div class="stat-icon-box" style="background: rgba(139, 92, 246, 0.1); color: var(--color-purple);">
                                <i class="la la-user-plus"></i>
                            </div>
                        </div>
                        <div class="stat-value mb-1">۲</div>
                        <div class="progress custom-progress mb-2">
                            <div class="progress-bar" style="width: 20%; background-color: var(--color-purple);"></div>
                        </div>
                        <small class="text-muted font-weight-600 font-small-2">۳ ثبت ورود امروز</small>
                    </div>
                </a>
            </div>

            {{-- درخواست تعمیرات --}}
            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-3">
                <a href="#" class="stat-card-link">
                    <div class="card stat-card-custom theme-danger">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted font-small-3 font-weight-600">خرابی باز</span>
                            <div class="stat-icon-box" style="background: rgba(239, 68, 68, 0.1); color: var(--color-danger);">
                                <i class="la la-wrench"></i>
                            </div>
                        </div>
                        <div class="stat-value mb-1" style="color: var(--color-danger);">۵</div>
                        <div class="progress custom-progress mb-2">
                            <div class="progress-bar" style="width: 50%; background-color: var(--color-danger);"></div>
                        </div>
                        <small class="text-danger font-weight-600 font-small-2">۲ مورد اولویت بالا</small>
                    </div>
                </a>
            </div>
        </div>

        {{-- ۳. بخش میانبرها + رویدادها --}}
        <div class="row mb-4">
            
            {{-- دسترسی سریع --}}
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="card custom-dashboard-card h-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2">
                            <i class="la la-bolt text-primary" style="font-size:22px;"></i>
                            <span>دسترسی سریع به عملیات‌ها</span>
                        </div>
                        <small class="text-muted font-weight-normal">میانبرهای پرکاربرد سیستم</small>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-md-4 col-sm-6 mb-3">
                                <a href="{{ route('resident.register') }}" class="btn btn-quick-action btn-quick-primary w-100">
                                    <i class="la la-user-plus"></i>
                                    <span>ثبت ساکن جدید</span>
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <a href="#" class="btn btn-quick-action btn-quick-success w-100">
                                    <i class="la la-file-text"></i>
                                    <span>تنظیم قرارداد</span>
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <a href="#" class="btn btn-quick-action btn-quick-info w-100">
                                    <i class="la la-home"></i>
                                    <span>تعریف اتاق جدید</span>
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <a href="#" class="btn btn-quick-action btn-quick-purple w-100">
                                    <i class="la la-id-card"></i>
                                    <span>صدور کارت مهمان</span>
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <a href="#" class="btn btn-quick-action btn-quick-warning w-100">
                                    <i class="la la-wrench"></i>
                                    <span>ثبت درخواست تعمیر</span>
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <a href="#" class="btn btn-quick-action btn-quick-danger w-100">
                                    <i class="la la-calculator"></i>
                                    <span>ثبت اجاره / دریافت</span>
                                </a>
                            </div>
                        </div>

                        {{-- ویجت وضعیت ظرفیت --}}
                        <div class="p-3" style="background: #f8fafc; border-radius: 14px; border: 1px solid #e2e8f0;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="font-small-3 font-weight-bold text-dark">وضعیت تکمیل ظرفیت خوابگاه</span>
                                <span class="badge bg-primary text-white px-2 py-1" style="border-radius: 6px; font-size: 12px;">۷۵٪ تکمیل</span>
                            </div>
                            <div class="progress custom-progress" style="height: 8px !important;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- آخرین اعلانات به‌صورت تایم‌لاین --}}
            <div class="col-lg-4">
                <div class="card custom-dashboard-card h-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2">
                            <i class="la la-bell text-primary" style="font-size:22px;"></i>
                            <span>آخرین فعالیت‌ها</span>
                        </div>
                        <a href="#" class="font-small-2 text-primary font-weight-600 text-decoration-none">مشاهده همه</a>
                    </div>
                    <div class="card-body p-4">
                        <div class="activity-stream">

                            <div class="activity-item-modern">
                                <div class="activity-dot" style="border-color: var(--color-success);"></div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="font-small-3 text-dark">ثبت قرارداد جدید</strong>
                                    <span class="text-muted font-small-2">۱۰ دقیقه پیش</span>
                                </div>
                                <p class="mb-0 text-muted font-small-2">قرارداد برای ساکن «احمد امیری» تنظیم شد.</p>
                            </div>

                            <div class="activity-item-modern">
                                <div class="activity-dot" style="border-color: var(--color-warning);"></div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="font-small-3 text-dark">درخواست تعمیرات</strong>
                                    <span class="text-muted font-small-2">۱ ساعت پیش</span>
                                </div>
                                <p class="mb-0 text-muted font-small-2">خرابی لوله‌کشی اتاق ۲۰۳ گزارش شد.</p>
                            </div>

                            <div class="activity-item-modern">
                                <div class="activity-dot" style="border-color: var(--color-info);"></div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="font-small-3 text-dark">ورود مهمان جدید</strong>
                                    <span class="text-muted font-small-2">۲ ساعت پیش</span>
                                </div>
                                <p class="mb-0 text-muted font-small-2">مهمان آقای «محمودی» ثبت گردید.</p>
                            </div>

                            <div class="activity-item-modern">
                                <div class="activity-dot" style="border-color: var(--color-primary);"></div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="font-small-3 text-dark">ثبت ساکن جدید</strong>
                                    <span class="text-muted font-small-2">۴ ساعت پیش</span>
                                </div>
                                <p class="mb-0 text-muted font-small-2">اطلاعات پرونده «محمد رضایی» تکمیل شد.</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ۴. بنر هشدار نسخه دیمو --}}
        <div class="alert alert-demo-custom p-3 font-small-3 d-flex align-items-center shadow-sm">
            <i class="la la-info-circle ml-2" style="font-size: 24px;"></i>
            <span>این صفحه در حال حاضر در حالت <strong>پیش‌نمایش (Demo)</strong> قرار دارد. داده‌های درون کارت‌ها تستی بوده و پس از فراخوانی متغیرهای لاراول به‌روزرسانی می‌شوند.</span>
        </div>

    </div>
</div>

@endsection
@extends('layouts.generalLayouts')

@section('content')

    <div class="row" style="direction: rtl; text-align: right;">
        <div class="col-12">
            {{-- بنر خوش‌آمدگویی و عنوان بالای صفحه --}}
            <div class="top-banner mb-4"
                style="border-radius: 12px; padding: 22px 20px; color: #ffffff; box-shadow: 0 4px 12px rgba(26, 86, 219, 0.15);">
                <div class="d-flex align-items-center">
                    <div class="banner-icon ml-3"
                        style="background: rgba(255,255,255,0.18); width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
                        <i class="la la-bolt text-white" style="font-size:24px;"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-1 font-weight-bold" style="letter-spacing: -0.5px;">پیشخوان مدیریتی سیستم
                        </h5>
                        <p class="mb-0" style="color:rgba(255,255,255,.8); font-size:13px;">دسترسی سریع به عملیات‌های اصلی،
                            آخرین اعلانات و وضعیت لحظه‌ای خوابگاه</p>
                    </div>
                </div>
            </div>

            {{-- استایل‌های سازمانی و حرفه‌ای پالت لوکس --}}
            <style>
                .stat-card-link {
                    text-decoration: none !important;
                    display: block;
                }

                .stat-card-custom {
                    background: #ffffff;
                    border: 1px solid #e2e8f0 !important;
                    border-radius: 12px !important;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
                    transition: transform 0.2s, box-shadow 0.2s;
                }

                .stat-card-custom:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
                }

                .stat-icon-box {
                    width: 44px;
                    height: 44px;
                    border-radius: 10px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 22px;
                }

                .custom-dashboard-card {
                    background: #ffffff;
                    border: 1px solid #e2e8f0 !important;
                    border-radius: 12px !important;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
                    overflow: hidden;
                }

                .custom-dashboard-card .card-header {
                    background: #f8fafc;
                    border-bottom: 1px solid #e2e8f0;
                    padding: 15px 20px;
                    font-weight: bold;
                    color: #1e293b;
                    display: flex;
                    align-items: center;
                }

                .custom-dashboard-card .card-header i {
                    font-size: 18px;
                    color: #1a56db;
                    margin-left: 8px;
                }

                .btn-quick-action {
                    border-radius: 8px !important;
                    font-size: 13.5px;
                    font-weight: 600;
                    padding: 12px 16px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                    transition: all 0.2s;
                    border: 1px solid transparent;
                }

                .btn-quick-primary {
                    background: rgba(26, 86, 219, 0.07);
                    color: #1a56db;
                }

                .btn-quick-primary:hover {
                    background: #1a56db;
                    color: #ffffff;
                }

                .btn-quick-success {
                    background: rgba(22, 163, 74, 0.07);
                    color: #16a34a;
                }

                .btn-quick-success:hover {
                    background: #16a34a;
                    color: #ffffff;
                }

                .btn-quick-info {
                    background: rgba(14, 165, 233, 0.07);
                    color: #0ea5e9;
                }

                .btn-quick-info:hover {
                    background: #0ea5e9;
                    color: #ffffff;
                }

                .btn-quick-purple {
                    background: rgba(118, 75, 162, 0.07);
                    color: #764ba2;
                }

                .btn-quick-purple:hover {
                    background: #764ba2;
                    color: #ffffff;
                }

                .btn-quick-warning {
                    background: rgba(234, 88, 12, 0.07);
                    color: #ea580c;
                }

                .btn-quick-warning:hover {
                    background: #ea580c;
                    color: #ffffff;
                }

                .notice-item {
                    border-bottom: 1px solid #f1f5f9;
                    padding: 12px 0;
                    transition: background 0.2s;
                }

                .notice-item:last-child {
                    border-bottom: none;
                }

                .progress-mini {
                    height: 4px;
                    background-color: #f1f5f9;
                    border-radius: 10px;
                    overflow: hidden;
                    margin-top: 6px;
                    margin-bottom: 6px;
                }
            </style>

            {{-- بخش اول: کارت‌های شش‌گانه آمار بالایی (با قابلیت اسکرول افقی تمیز در موبایل) --}}
            <div class="overflow-auto mb-4" style="white-space: nowrap; padding-bottom: 8px;">
                <div class="d-inline-flex gap-3" style="min-width: min-content; display: flex !important;">

                    {{-- ساکنین --}}
                    <a href="{{ route('resident.list') }}" class="stat-card-link" style="width: 230px; margin-left: 15px;">
                        <div class="card stat-card-custom">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted font-small-3">ساکنین</span>
                                    <div class="stat-icon-box" style="background: rgba(26, 86, 219, 0.08); color: #1a56db;">
                                        <i class="la la-users"></i></div>
                                </div>
                                <h3 class="font-weight-bold mb-0 text-dark">۴۸</h3>
                                <div class="progress-mini">
                                    <div class="progress-bar bg-primary" style="width: 80%"></div>
                                </div>
                                <small class="text-success font-weight-600 font-small-2"><i class="la la-arrow-up"></i> ۱۲٪
                                    رشد</small>
                            </div>
                        </div>
                    </a>

                    {{-- اتاق‌ها --}}
                    <a href="" class="stat-card-link" style="width: 230px; margin-left: 15px;">
                        <div class="card stat-card-custom">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted font-small-3">اتاق‌ها</span>
                                    <div class="stat-icon-box" style="background: rgba(22, 163, 74, 0.08); color: #16a34a;">
                                        <i class="la la-home"></i></div>
                                </div>
                                <h3 class="font-weight-bold mb-0 text-dark">۲۴</h3>
                                <div class="progress-mini">
                                    <div class="progress-bar bg-success" style="width: 60%"></div>
                                </div>
                                <small class="text-muted font-weight-600 font-small-2">۸ اتاق خالی</small>
                            </div>
                        </div>
                    </a>

                    {{-- قراردادها --}}
                    <a href="" class="stat-card-link" style="width: 230px; margin-left: 15px;">
                        <div class="card stat-card-custom">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted font-small-3">قراردادهای فعال</span>
                                    <div class="stat-icon-box"
                                        style="background: rgba(14, 165, 233, 0.08); color: #0ea5e9;"><i
                                            class="la la-file-text"></i></div>
                                </div>
                                <h3 class="font-weight-bold mb-0 text-dark">۴۵</h3>
                                <div class="progress-mini">
                                    <div class="progress-bar bg-info" style="width: 75%"></div>
                                </div>
                                <small class="text-muted font-weight-600 font-small-2">کل درآمد: ۱۲۵M</small>
                            </div>
                        </div>
                    </a>

                    {{-- پرداخت معوق --}}
                    <a href="" class="stat-card-link" style="width: 230px; margin-left: 15px;">
                        <div class="card stat-card-custom">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted font-small-3">پرداخت معوق</span>
                                    <div class="stat-icon-box" style="background: rgba(234, 88, 12, 0.08); color: #ea580c;">
                                        <i class="la la-money"></i></div>
                                </div>
                                <h3 class="font-weight-bold mb-0 text-danger">۳</h3>
                                <div class="progress-mini">
                                    <div class="progress-bar bg-warning" style="width: 30%"></div>
                                </div>
                                <small class="text-danger font-weight-600 font-small-2">مبلغ: ۴.۵M افغانی</small>
                            </div>
                        </div>
                    </a>

                    {{-- مهمانان داخل --}}
                    <a href="" class="stat-card-link" style="width: 230px; margin-left: 15px;">
                        <div class="card stat-card-custom">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted font-small-3">مهمانان داخل</span>
                                    <div class="stat-icon-box"
                                        style="background: rgba(118, 75, 162, 0.08); color: #764ba2;"><i
                                            class="la la-user-plus"></i></div>
                                </div>
                                <h3 class="font-weight-bold mb-0 text-dark">۲</h3>
                                <div class="progress-mini">
                                    <div class="progress-bar style-bar" style="width: 20%; background-color: #764ba2;">
                                    </div>
                                </div>
                                <small class="text-muted font-weight-600 font-small-2">۳ مهمان امروز</small>
                            </div>
                        </div>
                    </a>

                    {{-- درخواست باز --}}
                    <a href="" class="stat-card-link" style="width: 230px;">
                        <div class="card stat-card-custom">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted font-small-3">درخواست فنی باز</span>
                                    <div class="stat-icon-box" style="background: rgba(220, 38, 38, 0.08); color: #dc2626;">
                                        <i class="la la-wrench"></i></div>
                                </div>
                                <h3 class="font-weight-bold mb-0 text-dark">۵</h3>
                                <div class="progress-mini">
                                    <div class="progress-bar bg-danger" style="width: 50%"></div>
                                </div>
                                <small class="text-danger font-weight-600 font-small-2">۲ مورد اولویت فوری</small>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

            {{-- بخش دوم: دسترسی سریع و اعلانات سیستم --}}
            <div class="row mb-4">
                {{-- دسترسی سریع --}}
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="card custom-dashboard-card h-100">
                        <div class="card-header">
                            <i class="la la-bolt"></i>
                            <span>دسترسی سریع به عملیات‌ها</span>
                        </div>
                        <div class="card-body py-4">
                            <div class="row g-3">
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <a href="{{ route('resident.register') }}"
                                        class="btn btn-quick-action btn-quick-primary w-100">
                                        <i class="la la-user-plus" style="font-size: 18px;"></i> ثبت ساکن جدید
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <a href="" class="btn btn-quick-action btn-quick-success w-100">
                                        <i class="la la-file-text" style="font-size: 18px;"></i> تنظیم قرارداد جدید
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <a href="" class="btn btn-quick-action btn-quick-info w-100">
                                        <i class="la la-home" style="font-size: 18px;"></i> تعریف اتاق جدید
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <a href="" class="btn btn-quick-action btn-quick-purple w-100">
                                        <i class="la la-user" style="font-size: 18px;"></i> کارت ورود مهمان
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <a href="" class="btn btn-quick-action btn-quick-warning w-100">
                                        <i class="la la-wrench" style="font-size: 18px;"></i> ثبت درخواست تعمیر
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- آخرین اعلانات --}}
                <div class="col-lg-4">
                    <div class="card custom-dashboard-card h-100">
                        <div class="card-header">
                            <i class="la la-bullhorn"></i>
                            <span>آخرین رویدادها و اعلانات</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="notice-list">
                                <div class="notice-item">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="font-weight-bold" style="color: #334155; font-size: 13px;">🔔 قرارداد
                                            جدید ثبت شد</span>
                                        <small class="text-muted font-small-2">۱۰ دقیقه پیش</small>
                                    </div>
                                </div>
                                <div class="notice-item">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="font-weight-bold" style="color: #334155; font-size: 13px;">📝 درخواست
                                            تعمیر اتاق ۲۰۳</span>
                                        <small class="text-muted font-small-2">۱ ساعت پیش</small>
                                    </div>
                                </div>
                                <div class="notice-item">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="font-weight-bold" style="color: #334155; font-size: 13px;">👤 ساکن
                                            جدید: محمد رضایی</span>
                                        <small class="text-muted font-small-2">۳ ساعت پیش</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- بنر هشدار نسخه دیمو --}}
            <div class="alert mt-3 mb-0 py-2 font-small-3 d-flex align-items-center"
                style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; border-radius: 8px;">
                <i class="la la-info-circle ml-2" style="font-size: 18px;"></i>
                <span>این نسخه <strong>دیمو (Demo)</strong> است — داده‌ها به صورت نمونه نمایش داده شده‌اند و پس از اتصال
                    دیتابیس واقعی هماهنگ خواهند شد.</span>
            </div>

        </div>
    </div>

@endsection
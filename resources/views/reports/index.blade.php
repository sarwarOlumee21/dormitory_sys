@extends('layouts.generalLayouts')

@section('content')

<div class="row" style="direction: rtl; text-align: right;">
    <div class="col-12">

        {{-- بنر بالایی صفحه با استایل مدرن، یکپارچه و آبی سازمانی --}}
        <div class="top-banner mb-4" style="border-radius: 12px; padding: 22px 20px; color: #ffffff; box-shadow: 0 4px 12px rgba(26, 86, 219, 0.15);">
            <div class="d-flex align-items-center">
                <div class="banner-icon ml-3" style="background: rgba(255,255,255,0.18); width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
                    <i class="la la-dashboard text-white" style="font-size:24px;"></i>
                </div>
                <div>
                    <h5 class="text-white mb-1 font-weight-bold" style="letter-spacing: -0.5px;">داشبورد مدیریتی و خلاصه وضعیت خوابگاه</h5>
                    <p class="mb-0" style="color:rgba(255,255,255,.8); font-size:13px;">مرور سریع آمار ساکنین، وضعیت مالی، ظرفیت اتاق‌ها و درخواست‌های فنی</p>
                </div>
            </div>
        </div>

        {{-- استایل‌های اختصاصی و حرفه‌ای سیستم یکپارچه --}}
        <style>
            .stat-card {
                background: #ffffff;
                border: 1px solid #e2e8f0 !important;
                border-radius: 12px !important;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
                transition: transform 0.2s, box-shadow 0.2s;
            }
            .stat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            }
            .stat-icon {
                width: 44px;
                height: 44px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
            }
            .custom-card {
                background: #ffffff;
                border: 1px solid #e2e8f0 !important;
                border-radius: 12px !important;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                overflow: hidden;
            }
            .custom-card .card-header {
                background: #f8fafc;
                border-bottom: 1px solid #e2e8f0;
                padding: 15px 20px;
                font-weight: bold;
                color: #1e293b;
                display: flex;
                align-items: center;
            }
            .custom-card .card-header i {
                font-size: 18px;
                color: #1a56db;
                margin-left: 8px;
            }
            .table thead th {
                background-color: #1a56db !important;
                color: #ffffff !important;
                font-weight: 600;
                font-size: 13px;
                border: none !important;
                padding: 12px 10px;
            }
            .table tbody td {
                padding: 12px 10px;
                vertical-align: middle;
                font-size: 13px;
                color: #334155;
                border-bottom: 1px solid #f1f5f9 !important;
            }
            .table tbody tr:hover {
                background-color: #f8fafc;
            }
            .progress-custom {
                height: 8px;
                background-color: #f1f5f9;
                border-radius: 20px;
                overflow: hidden;
            }
            .progress-custom .progress-bar {
                border-radius: 20px;
            }
            .badge-status-pct {
                font-weight: 600;
                border-radius: 6px;
                padding: 4px 8px;
                font-size: 11.5px;
            }
            .btn-export {
                border-radius: 8px !important;
                font-size: 13px;
                font-weight: 600;
                padding: 8px 16px;
                margin-left: 5px;
                margin-bottom: 5px;
                transition: all 0.15s;
                border: 1px solid #cbd5e1;
                background: #ffffff;
                color: #475569;
            }
            .btn-export:hover {
                background: #f8fafc;
                color: #1a56db;
                border-color: #1a56db;
            }
        </style>

        {{-- بخش اول: کارت‌های چهارگانه آمار بالایی --}}
        <div class="row mb-2">
            {{-- کارت ساکنین --}}
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-small-3 d-block mb-1">ساکنین فعال</span>
                            <h2 class="font-weight-bold mb-1" style="color: #1e293b;">۴۸</h2>
                            <span class="font-small-2 text-success font-weight-600"><i class="la la-arrow-up"></i> +۳ این ماه</span>
                        </div>
                        <div class="stat-icon" style="background: rgba(26, 86, 219, 0.08); color: #1a56db;"><i class="la la-users"></i></div>
                    </div>
                </div>
            </div>
            {{-- کارت اتاق‌ها --}}
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-small-3 d-block mb-1">وضعیت اتاق‌ها</span>
                            <h2 class="font-weight-bold mb-1" style="color: #1e293b;">۲۴</h2>
                            <span class="font-small-2 text-info font-weight-600"><i class="la la-pie-chart"></i> ۸۵٪ اشغال</span>
                        </div>
                        <div class="stat-icon" style="background: rgba(14, 165, 233, 0.08); color: #0ea5e9;"><i class="la la-home"></i></div>
                    </div>
                </div>
            </div>
            {{-- کارت درآمد --}}
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-small-3 d-block mb-1">درآمد ماه (افغانی)</span>
                            <h2 class="font-weight-bold mb-1" style="color: #16a34a; font-size: 22px;">۱۵۶,۰۰۰</h2>
                            <span class="font-small-2 text-muted font-weight-600">۹ از ۱۲ پرداخت</span>
                        </div>
                        <div class="stat-icon" style="background: rgba(22, 163, 74, 0.08); color: #16a34a;"><i class="la la-money"></i></div>
                    </div>
                </div>
            </div>
            {{-- کارت درخواست‌ها --}}
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-small-3 d-block mb-1">درخواست باز</span>
                            <h2 class="font-weight-bold mb-1" style="color: #ea580c;">۵</h2>
                            <span class="font-small-2 text-danger font-weight-600"><i class="la la-warning"></i> ۱ فوری</span>
                        </div>
                        <div class="stat-icon" style="background: rgba(234, 88, 12, 0.08); color: #ea580c;"><i class="la la-wrench"></i></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- بخش دوم: نمودارها و جداول میانی --}}
        <div class="row">
            {{-- وضعیت اشغال بلوک‌ها --}}
            <div class="col-lg-6 mb-4">
                <div class="card custom-card h-100">
                    <div class="card-header">
                        <i class="la la-home"></i>
                        <span>اشغال اتاق‌ها</span>
                    </div>
                    <div class="card-body py-3">
                        @foreach([['A', '12', '75'], ['B', '8', '50'], ['C', '6', '100'], ['D', '4', '25']] as $b)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="font-weight-bold" style="color:#475569; font-size: 13px;">بلوک {{ $b[0] }}</span>
                                    <span class="font-weight-bold text-dark" style="font-size: 13px;">{{ $b[2] }}٪</span>
                                </div>
                                <div class="progress-custom mb-1">
                                    <div class="progress-bar bg-primary" style="width:{{ $b[2] }}%"></div>
                                </div>
                                <small class="text-muted font-small-2 d-block">{{ $b[1] }} اتاق</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- وضعیت مالی و پرداخت‌ها --}}
            <div class="col-lg-6 mb-4">
                <div class="card custom-card h-100">
                    <div class="card-header">
                        <i class="la la-money"></i>
                        <span>وضعیت پرداخت‌ها (۶ ماه)</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>ماه</th>
                                        <th>مبلغ</th>
                                        <th class="text-center">وضعیت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-weight-600">حمل ۱۴۰۴</td>
                                        <td class="font-weight-bold">۱۵۶,۰۰۰</td>
                                        <td class="text-center"><span class="badge-status-pct" style="background: rgba(22, 163, 74, 0.1); color: #16a34a;">۷۵٪</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-600">جوزا ۱۴۰۴</td>
                                        <td class="font-weight-bold">۱۶۸,۰۰۰</td>
                                        <td class="text-center"><span class="badge-status-pct" style="background: rgba(22, 163, 74, 0.15); color: #16a34a;">۱۰۰٪</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-600">جوزا ۱۴۰۳</td>
                                        <td class="font-weight-bold">۱۴۲,۰۰۰</td>
                                        <td class="text-center"><span class="badge-status-pct" style="background: rgba(234, 88, 12, 0.1); color: #ea580c;">۹۰٪</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- بخش سوم: خروجی گزارش‌ها --}}
        <div class="card custom-card mb-4">
            <div class="card-header">
                <i class="la la-download"></i>
                <span>خروجی گزارش (دیمو)</span>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center">
                    <button class="btn btn-export"><i class="la la-file-pdf-o text-danger"></i> PDF ساکنین</button>
                    <button class="btn btn-export"><i class="la la-file-excel-o text-success"></i> Excel پرداخت‌ها</button>
                    <button class="btn btn-export"><i class="la la-file-text-o text-info"></i> گزارش قراردادها</button>
                    <button class="btn btn-export"><i class="la la-print text-secondary"></i> چاپ خلاصه</button>
                </div>
                
                <div class="alert mt-3 mb-0 py-2 font-small-3 d-flex align-items-center" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; border-radius: 8px;">
                    <i class="la la-info-circle ml-2" style="font-size: 18px;"></i>
                    <span>در نسخه نهایی، گزارش‌ها از دیتابیس تولید می‌شوند.</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
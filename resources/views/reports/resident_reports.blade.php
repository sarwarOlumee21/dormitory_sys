@extends('layouts.generalLayouts')

@section('content')

<div class="row" style="direction: rtl; text-align: right;">
    <div class="col-12">

        {{-- بنر بالایی صفحه --}}
        <div class="top-banner mb-4" style="border-radius: 12px; padding: 22px 20px; color: #ffffff; box-shadow: 0 4px 12px rgba(26, 86, 219, 0.15); background: linear-gradient(135deg, #1a56db, #1e40af);">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <div class="d-flex align-items-center">
                    <div class="banner-icon ml-3" style="background: rgba(255,255,255,0.18); width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
                        <i class="la la-users text-white" style="font-size:24px;"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-1 font-weight-bold" style="letter-spacing: -0.5px;">گزارش‌دهی ساکنین خوابگاه</h5>
                        <p class="mb-0" style="color:rgba(255,255,255,.8); font-size:13px;">مشاهده، فیلتر و دریافت گزارش کامل وضعیت ساکنین، اتاق‌ها و اطلاعات ثبت‌نامی</p>
                    </div>
                </div>
                <div>
                    <span class="badge badge-pill" style="background: rgba(255,255,255,0.2); color:#fff; padding: 8px 14px; font-size: 12.5px;">
                        <i class="la la-calendar"></i> 1404-05-17
                    </span>
                </div>
            </div>
        </div>

        {{-- استایل‌های اختصاصی صفحه --}}
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
                justify-content: space-between;
                flex-wrap: wrap;
            }
            .custom-card .card-header .title-group {
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
                white-space: nowrap;
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
            .badge-status-pct {
                font-weight: 600;
                border-radius: 6px;
                padding: 5px 10px;
                font-size: 11.5px;
            }
            .status-active { background:#dcfce7; color:#15803d; }
            .status-inactive { background:#fee2e2; color:#b91c1c; }
            .status-pending { background:#fef9c3; color:#a16207; }
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
            .btn-filter-apply {
                background: #1a56db;
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 9px 22px;
                font-size: 13px;
                font-weight: 600;
            }
            .btn-filter-apply:hover { background:#1741ad; color:#fff; }
            .form-control-report {
                border-radius: 8px;
                border: 1px solid #cbd5e1;
                font-size: 13px;
                padding: 9px 12px;
                height: auto;
            }
            .avatar-circle {
                width: 34px;
                height: 34px;
                border-radius: 50%;
                background: #e0f2fe;
                color: #1a56db;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 13px;
                margin-left: 8px;
            }
            .empty-state {
                text-align: center;
                padding: 50px 20px;
                color: #94a3b8;
            }
            .empty-state i { font-size: 42px; margin-bottom: 10px; display:block; }
            .progress-custom {
                height: 8px;
                background-color: #f1f5f9;
                border-radius: 20px;
                overflow: hidden;
            }
            .progress-custom .progress-bar {
                border-radius: 20px;
            }
        </style>

        {{-- بخش اول: کارت‌های خلاصه آماری ساکنین (داده فیک) --}}
        <div class="row mb-2">
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-small-3 d-block mb-1">تعداد کل ساکنین</span>
                            <h2 class="font-weight-bold mb-1" style="color:#1e293b;">128</h2>
                            <span class="font-small-2 text-muted">ثبت‌شده در سیستم</span>
                        </div>
                        <div class="stat-icon" style="background:#e0f2fe; color:#0369a1;"><i class="la la-users"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-small-3 d-block mb-1">ساکنین فعال</span>
                            <h2 class="font-weight-bold mb-1" style="color:#1e293b;">104</h2>
                            <span class="font-small-2 text-muted">در حال اقامت</span>
                        </div>
                        <div class="stat-icon" style="background:#dcfce7; color:#15803d;"><i class="la la-user-check"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-small-3 d-block mb-1">ساکنین غیرفعال / خروجی</span>
                            <h2 class="font-weight-bold mb-1" style="color:#1e293b;">24</h2>
                            <span class="font-small-2 text-muted">خارج‌شده از خوابگاه</span>
                        </div>
                        <div class="stat-icon" style="background:#fee2e2; color:#b91c1c;"><i class="la la-user-times"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-small-3 d-block mb-1">درصد اشغال اتاق‌ها</span>
                            <h2 class="font-weight-bold mb-1" style="color:#1e293b;">81%</h2>
                            <span class="font-small-2 text-muted">از ظرفیت کل</span>
                        </div>
                        <div class="stat-icon" style="background:#fef9c3; color:#a16207;"><i class="la la-bed"></i></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- بخش دوم: فرم فیلتر گزارش (بدون اکشن واقعی) --}}
        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="title-group"><i class="la la-filter"></i><span>فیلتر گزارش ساکنین</span></div>
            </div>
            <div class="card-body">
                <form method="GET" action="#">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">جستجو (نام / شماره تماس)</label>
                            <input type="text" class="form-control form-control-report" placeholder="نام ساکن یا شماره تماس...">
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">وضعیت</label>
                            <select class="form-control form-control-report">
                                <option value="">همه</option>
                                <option value="active" selected>فعال</option>
                                <option value="inactive">غیرفعال</option>
                                <option value="pending">در انتظار تایید</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">شماره اتاق</label>
                            <input type="text" class="form-control form-control-report" placeholder="مثلا: 204">
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">از تاریخ ورود</label>
                            <input type="date" class="form-control form-control-report" value="2025-01-01">
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">تا تاریخ ورود</label>
                            <input type="date" class="form-control form-control-report" value="2025-08-01">
                        </div>
                        <div class="col-md-1 col-sm-6 mb-3 d-flex align-items-end">
                            <button type="button" class="btn btn-filter-apply w-100"><i class="la la-search"></i> اعمال</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- بخش سوم: جدول کامل گزارش ساکنین (داده فیک) --}}
        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="title-group"><i class="la la-table"></i><span>لیست تفصیلی ساکنین (8 نتیجه)</span></div>
                <span class="font-small-2 text-muted">به‌روزرسانی: 1404-05-17 10:42</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام کامل ساکن</th>
                                <th>شماره اتاق</th>
                                <th>دانشکده / رشته</th>
                                <th>شماره تماس</th>
                                <th>تاریخ ورود</th>
                                <th>وضعیت پرداخت</th>
                                <th>وضعیت اقامت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">ا</div><span class="font-weight-600">احمد رضایی</span></div></td>
                                <td>204</td>
                                <td>کامپیوتر ساینس</td>
                                <td>0799112233</td>
                                <td>1404-01-15</td>
                                <td><span class="badge-status-pct status-active">پرداخت‌شده</span></td>
                                <td><span class="badge-status-pct status-active">فعال</span></td>
                                <td><a href="#" class="btn btn-sm" style="color:#1a56db;" title="مشاهده جزئیات"><i class="la la-eye"></i></a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">م</div><span class="font-weight-600">محمد کریمی</span></div></td>
                                <td>108</td>
                                <td>مهندسی برق</td>
                                <td>0788223344</td>
                                <td>1403-11-02</td>
                                <td><span class="badge-status-pct status-pending">پرداخت جزئی</span></td>
                                <td><span class="badge-status-pct status-active">فعال</span></td>
                                <td><a href="#" class="btn btn-sm" style="color:#1a56db;" title="مشاهده جزئیات"><i class="la la-eye"></i></a></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">ز</div><span class="font-weight-600">زهرا احمدی</span></div></td>
                                <td>301</td>
                                <td>اقتصاد</td>
                                <td>0700554466</td>
                                <td>1404-02-20</td>
                                <td><span class="badge-status-pct status-active">پرداخت‌شده</span></td>
                                <td><span class="badge-status-pct status-pending">در انتظار</span></td>
                                <td><a href="#" class="btn btn-sm" style="color:#1a56db;" title="مشاهده جزئیات"><i class="la la-eye"></i></a></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">ع</div><span class="font-weight-600">علی حسینی</span></div></td>
                                <td>115</td>
                                <td>پزشکی</td>
                                <td>0777889900</td>
                                <td>1403-09-10</td>
                                <td><span class="badge-status-pct status-inactive">معوق</span></td>
                                <td><span class="badge-status-pct status-inactive">غیرفعال</span></td>
                                <td><a href="#" class="btn btn-sm" style="color:#1a56db;" title="مشاهده جزئیات"><i class="la la-eye"></i></a></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">س</div><span class="font-weight-600">سمیرا نوری</span></div></td>
                                <td>212</td>
                                <td>حقوق</td>
                                <td>0766778899</td>
                                <td>1404-03-05</td>
                                <td><span class="badge-status-pct status-active">پرداخت‌شده</span></td>
                                <td><span class="badge-status-pct status-active">فعال</span></td>
                                <td><a href="#" class="btn btn-sm" style="color:#1a56db;" title="مشاهده جزئیات"><i class="la la-eye"></i></a></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">ف</div><span class="font-weight-600">فرید امینی</span></div></td>
                                <td>309</td>
                                <td>کامپیوتر ساینس</td>
                                <td>0744556677</td>
                                <td>1404-04-18</td>
                                <td><span class="badge-status-pct status-pending">پرداخت جزئی</span></td>
                                <td><span class="badge-status-pct status-active">فعال</span></td>
                                <td><a href="#" class="btn btn-sm" style="color:#1a56db;" title="مشاهده جزئیات"><i class="la la-eye"></i></a></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">ن</div><span class="font-weight-600">نگین صادقی</span></div></td>
                                <td>117</td>
                                <td>ادبیات</td>
                                <td>0733445566</td>
                                <td>1403-12-27</td>
                                <td><span class="badge-status-pct status-active">پرداخت‌شده</span></td>
                                <td><span class="badge-status-pct status-active">فعال</span></td>
                                <td><a href="#" class="btn btn-sm" style="color:#1a56db;" title="مشاهده جزئیات"><i class="la la-eye"></i></a></td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">ح</div><span class="font-weight-600">حمید یوسفی</span></div></td>
                                <td>220</td>
                                <td>مهندسی عمران</td>
                                <td>0722334455</td>
                                <td>1403-08-14</td>
                                <td><span class="badge-status-pct status-inactive">معوق</span></td>
                                <td><span class="badge-status-pct status-inactive">غیرفعال</span></td>
                                <td><a href="#" class="btn btn-sm" style="color:#1a56db;" title="مشاهده جزئیات"><i class="la la-eye"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body border-top d-flex justify-content-between align-items-center">
                <span class="font-small-2 text-muted">نمایش 1 تا 8 از 128 نتیجه</span>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">قبلی</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">بعدی</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        {{-- بخش چهارم: کارت‌های تکمیلی و تفکیکی (داده فیک) --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card custom-card h-100">
                    <div class="card-header"><div class="title-group"><i class="la la-graduation-cap"></i><span>تفکیک بر اساس دانشکده</span></div></div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="font-small-3" style="color:#475569;">کامپیوتر ساینس</span>
                            <span class="badge badge-pill" style="background:#e0f2fe; color:#0369a1; padding:5px 10px;">34</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="font-small-3" style="color:#475569;">مهندسی برق</span>
                            <span class="badge badge-pill" style="background:#e0f2fe; color:#0369a1; padding:5px 10px;">21</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="font-small-3" style="color:#475569;">پزشکی</span>
                            <span class="badge badge-pill" style="background:#e0f2fe; color:#0369a1; padding:5px 10px;">18</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="font-small-3" style="color:#475569;">اقتصاد</span>
                            <span class="badge badge-pill" style="background:#e0f2fe; color:#0369a1; padding:5px 10px;">15</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-small-3" style="color:#475569;">حقوق</span>
                            <span class="badge badge-pill" style="background:#e0f2fe; color:#0369a1; padding:5px 10px;">12</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card custom-card h-100">
                    <div class="card-header"><div class="title-group"><i class="la la-bed"></i><span>وضعیت ظرفیت اتاق‌ها</span></div></div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="font-small-3 text-muted">اتاق‌های پر</span>
                            <span class="font-small-3 font-weight-600">52 / 64</span>
                        </div>
                        <div class="progress-custom mb-3">
                            <div class="progress-bar" style="width: 81%; background:#1a56db; height:100%;"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="font-small-3 text-muted">اتاق‌های خالی</span>
                            <span class="font-small-3 font-weight-600">12</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card custom-card h-100">
                    <div class="card-header"><div class="title-group"><i class="la la-clock"></i><span>ورود / خروج اخیر</span></div></div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="font-small-3" style="color:#475569;">فرید امینی - ورود</span>
                            <span class="font-small-2 text-muted">1404-04-18</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="font-small-3" style="color:#475569;">حمید یوسفی - خروج</span>
                            <span class="font-small-2 text-muted">1404-04-10</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="font-small-3" style="color:#475569;">سمیرا نوری - ورود</span>
                            <span class="font-small-2 text-muted">1404-03-05</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-small-3" style="color:#475569;">علی حسینی - خروج</span>
                            <span class="font-small-2 text-muted">1404-02-28</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- بخش پنجم: خروجی گزارش --}}
        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="title-group"><i class="la la-download"></i><span>خروجی گزارش ساکنین</span></div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center">
                    <button class="btn btn-export"><i class="la la-file-pdf-o text-danger"></i> خروجی PDF</button>
                    <button class="btn btn-export"><i class="la la-file-excel-o text-success"></i> خروجی Excel</button>
                    <button class="btn btn-export"><i class="la la-print text-secondary"></i> چاپ گزارش</button>
                </div>
                <div class="alert mt-3 mb-0 py-2 font-small-3 d-flex align-items-center" style="background:#eff6ff; color:#1e40af; border:1px solid #bfdbfe; border-radius:8px;">
                    <i class="la la-info-circle ml-2" style="font-size:18px;"></i>
                    <span>این صفحه با داده‌های فیک برای بررسی UI ساخته شده و به دیتابیس متصل نیست.</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
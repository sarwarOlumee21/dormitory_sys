@extends('layouts.generalLayouts')

@section('content')

<div class="row" style="direction: rtl; text-align: right;">
    <div class="col-12">

        {{-- بنر بالایی صفحه --}}
        <div class="top-banner mb-4" style="border-radius: 12px; padding: 22px 20px; color: #ffffff; box-shadow: 0 4px 12px rgba(26, 86, 219, 0.15); background: linear-gradient(135deg, #0f766e, #059669);">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <div class="d-flex align-items-center">
                    <div class="banner-icon ml-3" style="background: rgba(255,255,255,0.18); width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
                        <i class="la la-money text-white" style="font-size:24px;"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-1 font-weight-bold" style="letter-spacing: -0.5px;">بررسی و گزارش پرداخت‌ها</h5>
                        <p class="mb-0" style="color:rgba(255,255,255,.8); font-size:13px;">مشاهده وضعیت پرداخت‌ها، بدهکاران، رسیدها و درآمد خوابگاه</p>
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
                color: #059669;
                margin-left: 8px;
            }
            .table thead th {
                background-color: #059669 !important;
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
            .status-paid { background:#dcfce7; color:#15803d; }
            .status-overdue { background:#fee2e2; color:#b91c1c; }
            .status-partial { background:#fef9c3; color:#a16207; }
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
                color: #059669;
                border-color: #059669;
            }
            .btn-filter-apply {
                background: #059669;
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 9px 22px;
                font-size: 13px;
                font-weight: 600;
            }
            .btn-filter-apply:hover { background:#047857; color:#fff; }
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
                background: #d1fae5;
                color: #059669;
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
            .btn-icon-action {
                width: 30px;
                height: 30px;
                border-radius: 6px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin: 0 2px;
                border: 1px solid #e2e8f0;
                background: #fff;
                color: #475569;
                font-size: 13px;
            }
            .btn-icon-action:hover { background:#f8fafc; }
        </style>

        {{-- بخش اول: کارت‌های خلاصه مالی (داده فیک) --}}
        <div class="row mb-2">
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-small-3 d-block mb-1">مجموع درآمد این ماه</span>
                            <h2 class="font-weight-bold mb-1" style="color:#1e293b;">248,500 افغانی</h2>
                            <span class="font-small-2 text-muted">جمع‌شده تا امروز</span>
                        </div>
                        <div class="stat-icon" style="background:#d1fae5; color:#059669;"><i class="la la-money"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-small-3 d-block mb-1">پرداخت‌های تکمیل‌شده</span>
                            <h2 class="font-weight-bold mb-1" style="color:#1e293b;">86</h2>
                            <span class="font-small-2 text-muted">از 128 ساکن</span>
                        </div>
                        <div class="stat-icon" style="background:#dcfce7; color:#15803d;"><i class="la la-check-circle"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-small-3 d-block mb-1">مجموع بدهی معوق</span>
                            <h2 class="font-weight-bold mb-1" style="color:#1e293b;">42,000 افغانی</h2>
                            <span class="font-small-2 text-muted">از 18 ساکن</span>
                        </div>
                        <div class="stat-icon" style="background:#fee2e2; color:#b91c1c;"><i class="la la-exclamation-triangle"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-small-3 d-block mb-1">پرداخت جزئی</span>
                            <h2 class="font-weight-bold mb-1" style="color:#1e293b;">24</h2>
                            <span class="font-small-2 text-muted">نیاز به پیگیری</span>
                        </div>
                        <div class="stat-icon" style="background:#fef9c3; color:#a16207;"><i class="la la-clock-o"></i></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- بخش دوم: فرم فیلتر گزارش پرداخت --}}
        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="title-group"><i class="la la-filter"></i><span>فیلتر گزارش پرداخت</span></div>
            </div>
            <div class="card-body">
                <form method="GET" action="#">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">انتخاب ساکن</label>
                            <select class="form-control form-control-report">
                                <option value="">همه ساکنین</option>
                                <option value="1">احمد رضایی - اتاق 204</option>
                                <option value="2">محمد کریمی - اتاق 108</option>
                                <option value="3">زهرا احمدی - اتاق 301</option>
                                <option value="4">علی حسینی - اتاق 115</option>
                                <option value="5">سمیرا نوری - اتاق 212</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">وضعیت پرداخت</label>
                            <select class="form-control form-control-report">
                                <option value="">همه</option>
                                <option value="paid" selected>پرداخت‌شده</option>
                                <option value="partial">پرداخت جزئی</option>
                                <option value="overdue">معوق</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">روش پرداخت</label>
                            <select class="form-control form-control-report">
                                <option value="">همه</option>
                                <option value="cash">نقدی</option>
                                <option value="bank">بانکی</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">از تاریخ</label>
                            <input type="date" class="form-control form-control-report" value="2025-01-01">
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">تا تاریخ</label>
                            <input type="date" class="form-control form-control-report" value="2025-08-01">
                        </div>
                        <div class="col-md-1 col-sm-6 mb-3 d-flex align-items-end">
                            <button type="button" class="btn btn-filter-apply w-100"><i class="la la-search"></i> اعمال</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- بخش سوم: جدول کامل تراکنش‌های پرداخت (داده فیک) --}}
        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="title-group"><i class="la la-table"></i><span>لیست تراکنش‌های پرداخت (8 نتیجه)</span></div>
                <span class="font-small-2 text-muted">به‌روزرسانی: 1404-05-17 10:42</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام ساکن</th>
                                <th>شماره اتاق</th>
                                <th>شماره رسید</th>
                                <th>مبلغ</th>
                                <th>روش پرداخت</th>
                                <th>تاریخ پرداخت</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">ا</div><span class="font-weight-600">احمد رضایی</span></div></td>
                                <td>204</td>
                                <td>RCP-1042</td>
                                <td class="font-weight-600">3,500 افغانی</td>
                                <td>نقدی</td>
                                <td>1404-05-10</td>
                                <td><span class="badge-status-pct status-paid">پرداخت‌شده</span></td>
                                <td>
                                    <a href="#" class="btn-icon-action" title="مشاهده رسید"><i class="la la-eye"></i></a>
                                    <a href="#" class="btn-icon-action" title="چاپ رسید"><i class="la la-print"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">م</div><span class="font-weight-600">محمد کریمی</span></div></td>
                                <td>108</td>
                                <td>RCP-1041</td>
                                <td class="font-weight-600">1,800 افغانی</td>
                                <td>بانکی</td>
                                <td>1404-05-08</td>
                                <td><span class="badge-status-pct status-partial">پرداخت جزئی</span></td>
                                <td>
                                    <a href="#" class="btn-icon-action" title="مشاهده رسید"><i class="la la-eye"></i></a>
                                    <a href="#" class="btn-icon-action" title="چاپ رسید"><i class="la la-print"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">ز</div><span class="font-weight-600">زهرا احمدی</span></div></td>
                                <td>301</td>
                                <td>RCP-1040</td>
                                <td class="font-weight-600">3,500 افغانی</td>
                                <td>نقدی</td>
                                <td>1404-05-05</td>
                                <td><span class="badge-status-pct status-paid">پرداخت‌شده</span></td>
                                <td>
                                    <a href="#" class="btn-icon-action" title="مشاهده رسید"><i class="la la-eye"></i></a>
                                    <a href="#" class="btn-icon-action" title="چاپ رسید"><i class="la la-print"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">ع</div><span class="font-weight-600">علی حسینی</span></div></td>
                                <td>115</td>
                                <td>—</td>
                                <td class="font-weight-600">3,500 افغانی</td>
                                <td>—</td>
                                <td>—</td>
                                <td><span class="badge-status-pct status-overdue">معوق</span></td>
                                <td>
                                    <a href="#" class="btn-icon-action" title="ثبت پرداخت"><i class="la la-plus"></i></a>
                                    <a href="#" class="btn-icon-action" title="یادآوری"><i class="la la-bell"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">س</div><span class="font-weight-600">سمیرا نوری</span></div></td>
                                <td>212</td>
                                <td>RCP-1039</td>
                                <td class="font-weight-600">3,500 افغانی</td>
                                <td>نقدی</td>
                                <td>1404-05-01</td>
                                <td><span class="badge-status-pct status-paid">پرداخت‌شده</span></td>
                                <td>
                                    <a href="#" class="btn-icon-action" title="مشاهده رسید"><i class="la la-eye"></i></a>
                                    <a href="#" class="btn-icon-action" title="چاپ رسید"><i class="la la-print"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">ف</div><span class="font-weight-600">فرید امینی</span></div></td>
                                <td>309</td>
                                <td>RCP-1038</td>
                                <td class="font-weight-600">2,000 افغانی</td>
                                <td>بانکی</td>
                                <td>1404-04-28</td>
                                <td><span class="badge-status-pct status-partial">پرداخت جزئی</span></td>
                                <td>
                                    <a href="#" class="btn-icon-action" title="مشاهده رسید"><i class="la la-eye"></i></a>
                                    <a href="#" class="btn-icon-action" title="چاپ رسید"><i class="la la-print"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">ن</div><span class="font-weight-600">نگین صادقی</span></div></td>
                                <td>117</td>
                                <td>RCP-1037</td>
                                <td class="font-weight-600">3,500 افغانی</td>
                                <td>بانکی</td>
                                <td>1404-04-22</td>
                                <td><span class="badge-status-pct status-paid">پرداخت‌شده</span></td>
                                <td>
                                    <a href="#" class="btn-icon-action" title="مشاهده رسید"><i class="la la-eye"></i></a>
                                    <a href="#" class="btn-icon-action" title="چاپ رسید"><i class="la la-print"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td><div class="d-flex align-items-center"><div class="avatar-circle">ح</div><span class="font-weight-600">حمید یوسفی</span></div></td>
                                <td>220</td>
                                <td>—</td>
                                <td class="font-weight-600">3,500 افغانی</td>
                                <td>—</td>
                                <td>—</td>
                                <td><span class="badge-status-pct status-overdue">معوق</span></td>
                                <td>
                                    <a href="#" class="btn-icon-action" title="ثبت پرداخت"><i class="la la-plus"></i></a>
                                    <a href="#" class="btn-icon-action" title="یادآوری"><i class="la la-bell"></i></a>
                                </td>
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

        {{-- بخش چهارم: کارت‌های تکمیلی مالی (داده فیک) --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card custom-card h-100">
                    <div class="card-header"><div class="title-group"><i class="la la-exclamation-circle"></i><span>بدهکاران برتر</span></div></div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="font-small-3" style="color:#475569;">علی حسینی - اتاق 115</span>
                            <span class="badge badge-pill" style="background:#fee2e2; color:#b91c1c; padding:5px 10px;">3,500 افغانی</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="font-small-3" style="color:#475569;">حمید یوسفی - اتاق 220</span>
                            <span class="badge badge-pill" style="background:#fee2e2; color:#b91c1c; padding:5px 10px;">3,500 افغانی</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="font-small-3" style="color:#475569;">محمد کریمی - اتاق 108</span>
                            <span class="badge badge-pill" style="background:#fef9c3; color:#a16207; padding:5px 10px;">1,700 افغانی</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-small-3" style="color:#475569;">فرید امینی - اتاق 309</span>
                            <span class="badge badge-pill" style="background:#fef9c3; color:#a16207; padding:5px 10px;">1,500 افغانی</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card custom-card h-100">
                    <div class="card-header"><div class="title-group"><i class="la la-pie-chart"></i><span>تفکیک روش پرداخت</span></div></div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="font-small-3 text-muted">نقدی</span>
                            <span class="font-small-3 font-weight-600">64%</span>
                        </div>
                        <div class="progress-custom mb-3" style="height:8px; background:#f1f5f9; border-radius:20px; overflow:hidden;">
                            <div class="progress-bar" style="width: 64%; background:#059669; height:100%; border-radius:20px;"></div>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="font-small-3 text-muted">بانکی</span>
                            <span class="font-small-3 font-weight-600">36%</span>
                        </div>
                        <div class="progress-custom" style="height:8px; background:#f1f5f9; border-radius:20px; overflow:hidden;">
                            <div class="progress-bar" style="width: 36%; background:#0ea5e9; height:100%; border-radius:20px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card custom-card h-100">
                    <div class="card-header"><div class="title-group"><i class="la la-history"></i><span>آخرین تراکنش‌ها</span></div></div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="font-small-3" style="color:#475569;">احمد رضایی - 3,500 افغانی</span>
                            <span class="font-small-2 text-muted">1404-05-10</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="font-small-3" style="color:#475569;">محمد کریمی - 1,800 افغانی</span>
                            <span class="font-small-2 text-muted">1404-05-08</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="font-small-3" style="color:#475569;">زهرا احمدی - 3,500 افغانی</span>
                            <span class="font-small-2 text-muted">1404-05-05</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-small-3" style="color:#475569;">سمیرا نوری - 3,500 افغانی</span>
                            <span class="font-small-2 text-muted">1404-05-01</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- بخش پنجم: خروجی گزارش --}}
        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="title-group"><i class="la la-download"></i><span>خروجی گزارش پرداخت</span></div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center">
                    <button class="btn btn-export"><i class="la la-file-pdf-o text-danger"></i> خروجی PDF</button>
                    <button class="btn btn-export"><i class="la la-file-excel-o text-success"></i> خروجی Excel</button>
                    <button class="btn btn-export"><i class="la la-print text-secondary"></i> چاپ گزارش</button>
                </div>
                <div class="alert mt-3 mb-0 py-2 font-small-3 d-flex align-items-center" style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; border-radius:8px;">
                    <i class="la la-info-circle ml-2" style="font-size:18px;"></i>
                    <span>این صفحه با داده‌های فیک برای بررسی UI ساخته شده و به دیتابیس متصل نیست.</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
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

        {{-- بخش اول: فرم فیلتر گزارش پرداخت (در بالای صفحه) --}}
        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="title-group"><i class="la la-filter"></i><span>فیلتر گزارش پرداخت</span></div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.index') }}">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">جستجو با نام ساکن</label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-report" placeholder="مثلا: احمد رضایی">
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">آیدی ساکن</label>
                            <input type="text" name="resident_code" value="{{ request('resident_code') }}" class="form-control form-control-report" placeholder="مثلا: RES-0021">
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">وضعیت پرداخت</label>
                            <select name="status" class="form-control form-control-report">
                                <option value="">همه</option>
                                <option value="paid">پرداخت‌شده</option>
                                <option value="partial">پرداخت جزئی</option>
                                <option value="overdue">معوق</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">از تاریخ</label>
                            <input type="date" name="from" value="{{ request('from') }}" class="form-control form-control-report">
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <label class="font-small-3 text-muted mb-1">تا تاریخ</label>
                            <input type="date" name="to" value="{{ request('to') }}" class="form-control form-control-report">
                        </div>
                        <div class="col-md-1 col-sm-6 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-filter-apply w-100"><i class="la la-search"></i></button>
                        </div>
                    </div>
                </form>

                {{-- خلاصه نتیجه بازه انتخابی --}}
                <div class="alert mt-2 mb-0 py-3 px-3" style="background:#ecfdf5; border:1px solid #a7f3d0; border-radius:8px;">
                    <div class="row text-center">
                        <div class="col-md-3 col-6 mb-2 mb-md-0">
                            <span class="d-block font-small-2 text-muted mb-1">مجموع پرداخت‌شده در بازه</span>
                            <span class="font-weight-bold" style="color:#059669; font-size:16px;">{{ number_format($totalPaid ?? 0) }} افغانی</span>
                        </div>
                        <div class="col-md-3 col-6 mb-2 mb-md-0">
                            <span class="d-block font-small-2 text-muted mb-1">تعداد پرداخت‌کنندگان کامل</span>
                            <span class="font-weight-bold" style="color:#15803d; font-size:16px;">{{ $paidCount ?? 0 }} نفر</span>
                        </div>
                        <div class="col-md-3 col-6">
                            <span class="d-block font-small-2 text-muted mb-1">پرداخت جزئی (کم‌پرداختی)</span>
                            <span class="font-weight-bold" style="color:#a16207; font-size:16px;">{{ $partialCount ?? 0 }} نفر</span>
                        </div>
                        <div class="col-md-3 col-6">
                            <span class="d-block font-small-2 text-muted mb-1">پرداخت‌نشده (معوق)</span>
                            <span class="font-weight-bold" style="color:#b91c1c; font-size:16px;">{{ $overdueCount ?? 0 }} نفر</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- بخش دوم: جدول کامل تراکنش‌های پرداخت (داده فیک) --}}
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
                            @if(isset($payments) && $payments->count())
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>{{ $loop->iteration + (($payments->currentPage()-1) * $payments->perPage()) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle">{{ optional($payment->resident)->name ? mb_substr(optional($payment->resident)->name,0,1) : '-' }}</div>
                                                <span class="font-weight-600">{{ optional($payment->resident)->name ?? '—' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ optional($payment->resident->room)->room_number ?? '—' }}</td>
                                        <td>{{ 'RCP-' . $payment->id }}</td>
                                        <td class="font-weight-600">{{ number_format($payment->amount) }} افغانی</td>
                                        <td>{{ $payment->notes ? $payment->notes : '—' }}</td>
                                        <td>{{ $payment->payment_date }}</td>
                                        <td><span class="badge-status-pct status-paid">پرداخت‌شده</span></td>
                                        <td>
                                            <a href="#" class="btn-icon-action" title="مشاهده رسید"><i class="la la-eye"></i></a>
                                            <a href="#" class="btn-icon-action" title="چاپ رسید"><i class="la la-print"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="empty-state">نتیجه‌ای یافت نشد</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body border-top d-flex justify-content-between align-items-center">
                @if(isset($payments))
                    <span class="font-small-2 text-muted">نمایش {{ $payments->firstItem() ?? 0 }} تا {{ $payments->lastItem() ?? 0 }} از {{ $payments->total() ?? 0 }} نتیجه</span>
                    <nav>
                        {!! $payments->appends(request()->query())->links('pagination::bootstrap-4') !!}
                    </nav>
                @else
                    <span class="font-small-2 text-muted">نتیجه‌ای برای نمایش وجود ندارد.</span>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection
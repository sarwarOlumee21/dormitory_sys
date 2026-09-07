@extends('layouts.generalLayouts')

@section('content')

    <div class="row" style="direction: rtl; text-align: right;">
        <div class="col-12">

            {{-- =========================================================
            بنر بالایی
            ========================================================== --}}
            <div class="top-banner mb-4"
                style="border-radius: 12px; padding: 22px 20px; color: #ffffff; box-shadow: 0 4px 12px rgba(26, 86, 219, 0.15); background: linear-gradient(135deg, #0f766e, #059669);">

                <div class="d-flex align-items-center justify-content-between flex-wrap">

                    <div class="d-flex align-items-center">

                        <div class="banner-icon ml-3 mr-1"
                            style="background: rgba(255,255,255,0.18); width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px);">

                            <i class="la la-money text-white" style="font-size:24px;"></i>

                        </div>

                        <div>

                            <h5 class="text-white mb-1 font-weight-bold" style="letter-spacing: -0.5px;">
                                گزارش مالی اقامت‌کنندگان
                            </h5>

                            <p class="mb-0" style="color:rgba(255,255,255,.8); font-size:13px;">
                                بررسی وضعیت قرارداد، پرداخت‌ها، بدهی و میزان پرداخت اقامت‌کنندگان
                            </p>

                        </div>

                    </div>

                    <div>

                        <span class="badge badge-pill"
                            style="background: rgba(255,255,255,0.2); color:#fff; padding: 8px 14px; font-size: 12.5px;">

                            <i class="la la-calendar"></i>

                            1404-05-17

                        </span>

                    </div>

                </div>

            </div>


            {{-- =========================================================
            CSS
            ========================================================== --}}
            <style>
                .stat-card {
                    background: #ffffff;
                    border: 1px solid #e2e8f0 !important;
                    border-radius: 12px !important;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
                    transition: transform 0.2s, box-shadow 0.2s;
                    padding: 20px;
                }

                .stat-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
                }

                .stat-icon {
                    width: 48px;
                    height: 48px;
                    border-radius: 10px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 22px;
                    flex-shrink: 0;
                }

                .stat-icon.contract {
                    background: #dbeafe;
                    color: #1d4ed8;
                }

                .stat-icon.expected {
                    background: #fef3c7;
                    color: #b45309;
                }

                .stat-icon.paid {
                    background: #d1fae5;
                    color: #059669;
                }

                .stat-icon.remaining {
                    background: #fee2e2;
                    color: #dc2626;
                }

                .stat-value {
                    font-size: 22px;
                    font-weight: 800;
                    color: #1e293b;
                }

                .stat-label {
                    font-size: 12.5px;
                    color: #64748b;
                }

                .stat-sub {
                    font-size: 11.5px;
                    margin-top: 4px;
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

                .form-control-report {
                    border-radius: 8px;
                    border: 1px solid #cbd5e1;
                    font-size: 13px;
                    padding: 9px 12px;
                    height: auto;
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

                .btn-filter-apply:hover {
                    background: #047857;
                    color: #fff;
                }

                .btn-filter-reset {
                    border-radius: 8px;
                    padding: 9px 18px;
                    font-size: 13px;
                    font-weight: 600;
                    border: 1px solid #cbd5e1;
                    background: #fff;
                    color: #475569;
                }

                .btn-filter-reset:hover {
                    background: #f8fafc;
                    color: #059669;
                    border-color: #059669;
                }

                .payment-status {
                    font-weight: 600;
                    border-radius: 6px;
                    padding: 5px 10px;
                    font-size: 11.5px;
                    display: inline-block;
                    white-space: nowrap;
                }

                .payment-full {
                    background: #d1fae5;
                    color: #047857;
                }

                .payment-partial {
                    background: #fef3c7;
                    color: #b45309;
                }

                .payment-none {
                    background: #fee2e2;
                    color: #b91c1c;
                }

                .payment-extra {
                    background: #dbeafe;
                    color: #1d4ed8;
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

                .resident-name {
                    display: flex;
                    align-items: center;
                }

                .money-paid {
                    color: #059669;
                    font-weight: 700;
                }

                .money-remaining {
                    color: #dc2626;
                    font-weight: 700;
                }

                .money-complete {
                    color: #047857;
                    font-weight: 700;
                }
            </style>


            {{-- =========================================================
            فیلتر گزارش مالی
            ========================================================== --}}
            <div class="card custom-card mb-4">

                <div class="card-header">

                    <div class="title-group">

                        <i class="la la-filter"></i>

                        <span>
                            فلتر گزارش مالی
                        </span>

                    </div>

                </div>

                <div class="card-body">

                    <form method="GET" action="">

                        <div class="row">

                            {{-- نام --}}
                            <div class="col-md-3 col-sm-6 mb-3">

                                <label class="font-small-3 text-muted mb-1">
                                    جستجو با نام
                                </label>

                                <input type="text" name="name" value="{{ $name ?? '' }}"
                                    class="form-control form-control-report" placeholder="مثلاً: احمد رضایی">

                            </div>


                            {{-- کد --}}
                            <div class="col-md-3 col-sm-6 mb-3">

                                <label class="font-small-3 text-muted mb-1">
                                    کد اقامت‌کننده
                                </label>

                                <input type="text" name="code" value="{{ $code ?? '' }}"
                                    class="form-control form-control-report" placeholder="مثلاً: RES-0021">

                            </div>


                            {{-- تاریخ --}}
                            <div class="col-md-2 col-sm-6 mb-3">

                                <label class="font-small-3 text-muted mb-1">
                                    تاریخ گزارش (ماه)
                                </label>

                                <input type="month" name="month" value="{{ $month ?? '' }}"
                                    class="form-control form-control-report">

                            </div>


                            {{-- وضعیت پرداخت --}}
                            <div class="col-md-2 col-sm-6 mb-3">

                                <label class="font-small-3 text-muted mb-1">
                                    وضعیت پرداخت
                                </label>

                                <select name="payment_status" class="form-control form-control-report">
                                    <option value="">همه</option>
                                    <option value="full" {{ (isset($payment_status) && $payment_status == 'full') ? 'selected' : '' }}>پرداخت کامل</option>
                                    <option value="partial" {{ (isset($payment_status) && $payment_status == 'partial') ? 'selected' : '' }}>پرداخت جزئی</option>
                                    <option value="none" {{ (isset($payment_status) && $payment_status == 'none') ? 'selected' : '' }}>بدون پرداخت</option>
                                </select>

                            </div>


                            {{-- دکمه --}}
                            <div class="col-md-2 col-sm-12 mb-3 d-flex align-items-end">

                                <button type="submit" class="btn btn-filter-apply w-100">

                                    <i class="la la-search"></i>

                                    اعمال گزارش

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            {{-- =========================================================
            کارت‌های آماری مالی
            ========================================================== --}}
            <div class="row mb-4">


                {{-- مجموع قراردادها --}}
                <div class="col-lg-4 col-md-6 mb-3">

                    <div class="stat-card d-flex align-items-center">

                        <div class="stat-icon contract ml-3">

                            <i class="la la-file-text"></i>

                        </div>

                        <div>

                            <span class="stat-label d-block">
                                مجموع قراردادها
                            </span>

                            <span class="stat-value">
                                {{ number_format($totals['contracts'] ?? 0) }}
                            </span>

                            <div class="stat-sub" style="color:#1d4ed8;">
                                افغانی
                            </div>

                        </div>

                    </div>

                </div>
                {{-- پرداخت شده --}}
                <div class="col-lg-4 col-md-6 mb-3">

                    <div class="stat-card d-flex align-items-center">

                        <div class="stat-icon paid ml-3">

                            <i class="la la-money"></i>

                        </div>

                        <div>

                            <span class="stat-label d-block">
                                مجموع پرداخت‌شده
                            </span>

                            <span class="stat-value">
                                {{ number_format($totals['paid'] ?? 0) }}
                            </span>

                            <div class="stat-sub" style="color:#059669;">
                                افغانی
                            </div>

                        </div>

                    </div>

                </div>


                {{-- باقی مانده --}}
                <div class="col-lg-4 col-md-6 mb-3">

                    <div class="stat-card d-flex align-items-center">

                        <div class="stat-icon remaining ml-3">

                            <i class="la la-warning"></i>

                        </div>

                        <div>

                            <span class="stat-label d-block">
                                مجموع باقی‌مانده
                            </span>

                            <span class="stat-value">
                                {{ number_format($totals['remaining'] ?? 0) }}
                            </span>

                            <div class="stat-sub" style="color:#dc2626;">
                                افغانی
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
            وضعیت پرداخت
            ========================================================== --}}
            <div class="row mb-4">


                {{-- پرداخت کامل --}}
                <div class="col-lg-4 col-md-4 mb-3">

                    <div class="stat-card">

                        <div class="d-flex align-items-center">

                            <div class="stat-icon paid ml-3">

                                <i class="la la-check-circle"></i>

                            </div>

                            <div>

                                <span class="stat-label d-block">
                                    پرداخت کامل
                                </span>

                                <span class="stat-value">
                                    {{ $counts['full'] ?? 0 }}
                                </span>

                                <div class="stat-sub" style="color:#059669;">
                                    نفر
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- پرداخت جزئی --}}
                <div class="col-lg-4 col-md-4 mb-3">

                    <div class="stat-card">

                        <div class="d-flex align-items-center">

                            <div class="stat-icon expected ml-3">

                                <i class="la la-adjust"></i>

                            </div>

                            <div>

                                <span class="stat-label d-block">
                                    پرداخت جزئی
                                </span>

                                <span class="stat-value">
                                    {{ $counts['partial'] ?? 0 }}
                                </span>

                                <div class="stat-sub" style="color:#b45309;">
                                    نفر
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- بدون پرداخت --}}
                <div class="col-lg-4 col-md-4 mb-3">

                    <div class="stat-card">

                        <div class="d-flex align-items-center">

                            <div class="stat-icon remaining ml-3">

                                <i class="la la-close"></i>

                            </div>

                            <div>

                                <span class="stat-label d-block">
                                    بدون پرداخت
                                </span>

                                <span class="stat-value">
                                    {{ $counts['none'] ?? 0 }}
                                </span>

                                <div class="stat-sub" style="color:#dc2626;">
                                    نفر
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
            جدول گزارش مالی
            ========================================================== --}}
            <div class="card custom-card mb-4">

                <div class="card-header">

                    <div class="title-group">

                        <i class="la la-money"></i>

                        <span>
                            گزارش مالی اقامت‌کنندگان ({{ $totalResults ?? 0 }} نتیجه)
                        </span>

                    </div>

                    <span class="font-small-2 text-muted">

                        تاریخ گزارش: {{ $month ?? 'تمامی ماه‌ها' }}

                    </span>

                </div>


                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table mb-0">

                            <thead>

                                <tr>

                                    <th>#</th>
                                    <th>نام اقامت‌کننده</th>
                                    <th>کد</th>
                                    <th>اتاق</th>
                                    <th>مبلغ قرارداد</th>
                                    <th>پرداخت‌شده</th>
                                    <th>تعداد دفعات پرداخت شده</th>
                                    <th>تاریخ آخرین پرداخت</th>
                                    <th>باقی‌مانده</th>
                                    <th>وضعیت</th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse(($items ?? []) as $index => $item)
                                    <tr>

                                        <td>{{ $index + 1 }}</td>

                                        <td>

                                            <div class="resident-name">

                                                <div class="avatar-circle">
                                                    {{ mb_substr($item['name'] ?? '', 0, 1) }}
                                                </div>

                                                <strong>
                                                    {{ $item['name'] ?? '-' }}
                                                </strong>

                                            </div>

                                        </td>

                                        <td>
                                            {{ $item['resident_code'] ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $item['room_number'] ?? '-' }}
                                        </td>

                                        <td>
                                            {{ number_format($item['contract_amount'] ?? 0) }} افغانی
                                        </td>

                                        <td class="money-paid">
                                            {{ number_format($item['paid'] ?? 0) }} افغانی
                                        </td>
                                        <td>
                                            {{ $item['payment_count'] ?? 0 }}
                                        </td>
                                        <td>
                                            {{ $item['last_payment_date'] ?? '-' }}
                                        </td>

                                        <td class="{{ ($item['remaining'] ?? 0) > 0 ? 'money-remaining' : 'money-complete' }}">
                                            {{ number_format($item['remaining'] ?? 0) }} افغانی
                                        </td>

                                        <td>

                                            @if(($item['status'] ?? '') == 'full')
                                                <span class="payment-status payment-full">
                                                    <i class="la la-check-circle"></i>
                                                    پرداخت کامل
                                                </span>
                                            @elseif(($item['status'] ?? '') == 'partial')
                                                <span class="payment-status payment-partial">
                                                    <i class="la la-adjust"></i>
                                                    پرداخت جزئی
                                                </span>
                                            @else
                                                <span class="payment-status payment-none">
                                                    <i class="la la-close"></i>
                                                    بدون پرداخت
                                                </span>
                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="9" class="text-center">نتیجه‌ای یافت نشد</td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- پایین جدول --}}
                <div class="card-body border-top d-flex justify-content-between align-items-center flex-wrap">

                    <span class="font-small-2 text-muted">

                        نمایش {{ $totalResults ?? 0 }} اقامت‌کننده

                    </span>


                    <span class="font-small-2 text-muted">

                        مجموع پرداخت:

                        <strong style="color:#059669;">

                            {{ number_format($totals['paid'] ?? 0) }} افغانی

                        </strong>

                    </span>

                </div>

            </div>

        </div>
    </div>

@endsection
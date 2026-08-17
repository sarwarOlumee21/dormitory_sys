@extends('layouts.generalLayouts')

@section('content')

    <div class="row" style="direction: rtl; text-align: right;">
        <div class="col-12">

            {{-- =========================================================
                بنر بالایی
            ========================================================== --}}
            <div class="top-banner mb-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="d-flex align-items-center">
                        <div class="banner-icon ml-3">
                            <i class="la la-building text-white"></i>
                        </div>

                        <div>
                            <h5 class="text-white mb-1 font-weight-bold">
                                گزارش اقامت، مهمان‌ها و وضعیت اتاق‌ها
                            </h5>

                            <p class="mb-0">
                                بررسی تعداد اقامت‌کنندگان، مهمان‌ها، ظرفیت اتاق‌ها و وضعیت اشغال
                            </p>
                        </div>
                    </div>

                    <div class="mt-2 mt-sm-0">
                        <span class="banner-date">
                            <i class="la la-calendar"></i>
                            {{ $reportDate ?? now()->format('Y-m-d') }}
                        </span>
                    </div>
                </div>
            </div>


            {{-- =========================================================
                CSS
            ========================================================== --}}
            <style>
                .top-banner {
                    border-radius: 12px;
                    padding: 22px 20px;
                    color: #ffffff;
                    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
                    background: linear-gradient(135deg, #0f766e, #059669);
                }

                .banner-icon {
                    width: 48px;
                    height: 48px;
                    border-radius: 10px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: rgba(255, 255, 255, 0.18);
                    backdrop-filter: blur(4px);
                    font-size: 24px;
                }

                .top-banner p {
                    color: rgba(255, 255, 255, .82);
                    font-size: 13px;
                }

                .banner-date {
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    background: rgba(255, 255, 255, 0.18);
                    color: #ffffff;
                    padding: 8px 14px;
                    border-radius: 50px;
                    font-size: 12.5px;
                }

                /* کارت‌های آماری */
                .stat-card {
                    height: 100%;
                    min-height: 124px;
                    background: #ffffff;
                    border: 1px solid #e2e8f0 !important;
                    border-radius: 12px !important;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
                    transition: transform .2s ease, box-shadow .2s ease;
                    padding: 20px;
                    display: flex;
                    align-items: center;
                }

                .stat-card:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 12px 20px -8px rgba(15, 23, 42, 0.14);
                }

                .stat-content {
                    display: flex;
                    align-items: center;
                    gap: 16px;
                    width: 100%;
                }

                .stat-icon {
                    width: 50px;
                    height: 50px;
                    min-width: 50px;
                    border-radius: 11px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 23px;
                }

                .stat-info {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    gap: 4px;
                    min-width: 0;
                }

                .stat-label {
                    display: block;
                    font-size: 12.5px;
                    color: #64748b;
                    line-height: 1.5;
                }

                .stat-value {
                    display: block;
                    font-size: 24px;
                    line-height: 1.2;
                    font-weight: 800;
                    color: #1e293b;
                }

                .stat-sub {
                    font-size: 11.5px;
                    line-height: 1.4;
                    font-weight: 600;
                }

                .icon-resident {
                    background: #dbeafe;
                    color: #2563eb;
                }

                .icon-guest {
                    background: #f3e8ff;
                    color: #9333ea;
                }

                .icon-room {
                    background: #d1fae5;
                    color: #059669;
                }

                .icon-full {
                    background: #fee2e2;
                    color: #dc2626;
                }

                .icon-available {
                    background: #fef3c7;
                    color: #b45309;
                }

                .icon-capacity {
                    background: #e0f2fe;
                    color: #0284c7;
                }

                /* کارت عمومی */
                .custom-card {
                    background: #ffffff;
                    border: 1px solid #e2e8f0 !important;
                    border-radius: 12px !important;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
                    overflow: hidden;
                }

                .custom-card .card-header {
                    background: #f8fafc;
                    border-bottom: 1px solid #e2e8f0;
                    padding: 15px 20px;
                    font-weight: 700;
                    color: #1e293b;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    flex-wrap: wrap;
                    gap: 10px;
                }

                .title-group {
                    display: flex;
                    align-items: center;
                    gap: 9px;
                }

                .title-group i {
                    color: #059669;
                    font-size: 19px;
                }

                /* فرم */
                .form-control-report {
                    border-radius: 8px;
                    border: 1px solid #cbd5e1;
                    font-size: 13px;
                    padding: 9px 12px;
                    height: auto;
                    transition: border-color .2s, box-shadow .2s;
                }

                .form-control-report:focus {
                    border-color: #059669;
                    box-shadow: 0 0 0 .15rem rgba(5, 150, 105, .10);
                }

                .btn-filter-apply {
                    background: #059669;
                    color: #ffffff;
                    border: none;
                    border-radius: 8px;
                    padding: 9px 18px;
                    font-size: 13px;
                    font-weight: 600;
                    min-height: 40px;
                }

                .btn-filter-apply:hover {
                    background: #047857;
                    color: #ffffff;
                }

                .btn-filter-reset {
                    border-radius: 8px;
                    padding: 9px 18px;
                    font-size: 13px;
                    font-weight: 600;
                    border: 1px solid #cbd5e1;
                    background: #ffffff;
                    color: #475569;
                    min-height: 40px;
                }

                .btn-filter-reset:hover {
                    background: #f8fafc;
                    color: #059669;
                    border-color: #059669;
                }

                /* جدول */
                .report-table thead th {
                    background-color: #059669 !important;
                    color: #ffffff !important;
                    font-weight: 600;
                    font-size: 12.5px;
                    border: none !important;
                    padding: 13px 10px;
                    white-space: nowrap;
                    vertical-align: middle;
                }

                .report-table tbody td {
                    padding: 13px 10px;
                    vertical-align: middle;
                    font-size: 13px;
                    color: #334155;
                    border-bottom: 1px solid #f1f5f9 !important;
                }

                .report-table tbody tr:hover {
                    background-color: #f8fafc;
                }

                .person-info {
                    display: flex;
                    align-items: center;
                    gap: 9px;
                    min-width: 150px;
                }

                .avatar-circle {
                    width: 36px;
                    height: 36px;
                    min-width: 36px;
                    border-radius: 50%;
                    background: #d1fae5;
                    color: #047857;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: 700;
                    font-size: 13px;
                }

                .person-name {
                    font-weight: 700;
                    color: #1e293b;
                    display: block;
                    line-height: 1.4;
                }

                .person-code {
                    font-size: 11px;
                    color: #94a3b8;
                }

                .status-badge {
                    display: inline-flex;
                    align-items: center;
                    gap: 5px;
                    padding: 5px 10px;
                    border-radius: 6px;
                    font-size: 11.5px;
                    font-weight: 600;
                    white-space: nowrap;
                }

                .status-resident {
                    background: #dbeafe;
                    color: #1d4ed8;
                }

                .status-guest {
                    background: #f3e8ff;
                    color: #7e22ce;
                }

                .room-full {
                    background: #fee2e2;
                    color: #b91c1c;
                }

                .room-available {
                    background: #d1fae5;
                    color: #047857;
                }

                .room-partial {
                    background: #fef3c7;
                    color: #b45309;
                }

                .capacity-progress {
                    min-width: 120px;
                }

                .capacity-progress .progress {
                    height: 7px;
                    border-radius: 10px;
                    background: #e2e8f0;
                    overflow: hidden;
                }

                .capacity-progress .progress-bar {
                    background: #059669;
                    border-radius: 10px;
                }

                .capacity-text {
                    font-size: 11px;
                    color: #64748b;
                    margin-top: 5px;
                    font-weight: 600;
                }

                /* کارت وضعیت اتاق */
                .room-summary {
                    padding: 18px;
                    border: 1px solid #eef2f7;
                    border-radius: 10px;
                    height: 100%;
                    background: #ffffff;
                }

                .room-summary-icon {
                    width: 42px;
                    height: 42px;
                    border-radius: 9px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 20px;
                    margin-bottom: 12px;
                }

                .room-summary-title {
                    font-size: 12px;
                    color: #64748b;
                    margin-bottom: 5px;
                }

                .room-summary-value {
                    font-size: 23px;
                    font-weight: 800;
                    color: #1e293b;
                    line-height: 1.2;
                }

                @media (max-width: 575.98px) {
                    .top-banner {
                        padding: 18px 15px;
                    }

                    .stat-card {
                        min-height: 110px;
                        padding: 16px;
                    }

                    .stat-content {
                        gap: 13px;
                    }

                    .stat-value {
                        font-size: 21px;
                    }
                }
            </style>


            {{-- =========================================================
                فلتر گزارش
            ========================================================== --}}
            <div class="card custom-card mb-4">
                <div class="card-header">
                    <div class="title-group">
                        <i class="la la-filter"></i>
                        <span>فلتر گزارش اقامت و اتاق‌ها</span>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="">
                        <div class="row">

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-small-3 text-muted mb-1">جستجو با نام</label>
                                <input type="text"
                                       name="name"
                                       value="{{ $name ?? '' }}"
                                       class="form-control form-control-report"
                                       placeholder="نام اقامت‌کننده یا مهمان">
                            </div>

                            <div class="col-lg-2 col-md-6 mb-3">
                                <label class="font-small-3 text-muted mb-1">نوع شخص</label>
                                <select name="person_type" class="form-control form-control-report">
                                    <option value="">همه</option>
                                    <option value="resident" {{ ($person_type ?? '') == 'resident' ? 'selected' : '' }}>اقامت‌کننده</option>
                                    <option value="guest" {{ ($person_type ?? '') == 'guest' ? 'selected' : '' }}>مهمان</option>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-6 mb-3">
                                <label class="font-small-3 text-muted mb-1">شماره اتاق</label>
                                <input type="text"
                                       name="room_number"
                                       value="{{ $room_number ?? '' }}"
                                       class="form-control form-control-report"
                                       placeholder="مثلاً: 101">
                            </div>

                            <div class="col-lg-2 col-md-6 mb-3">
                                <label class="font-small-3 text-muted mb-1">وضعیت اتاق</label>
                                <select name="room_status" class="form-control form-control-report">
                                    <option value="">همه</option>
                                    <option value="full" {{ ($room_status ?? '') == 'full' ? 'selected' : '' }}>پر</option>
                                    <option value="available" {{ ($room_status ?? '') == 'available' ? 'selected' : '' }}>دارای ظرفیت</option>
                                    <option value="empty" {{ ($room_status ?? '') == 'empty' ? 'selected' : '' }}>خالی</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-12 mb-3 d-flex align-items-end">
                                <div class="d-flex w-100" style="gap: 8px;">
                                    <button type="submit" class="btn btn-filter-apply flex-fill">
                                        <i class="la la-search"></i>
                                        اعمال فلتر
                                    </button>

                                    <a href="{{ url()->current() }}" class="btn btn-filter-reset">
                                        <i class="la la-refresh"></i>
                                        حذف
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>


            {{-- =========================================================
                آمار اصلی
            ========================================================== --}}
            <div class="row mb-4">

                {{-- مجموع اقامت‌کنندگان --}}
                <div class="col-xl-6 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-icon icon-resident">
                                <i class="la la-users"></i>
                            </div>

                            <div class="stat-info">
                                <span class="stat-label">مجموع اقامت‌کنندگان</span>
                                <span class="stat-value">{{ $totals['residents'] ?? 0 }}</span>
                                <span class="stat-sub" style="color:#2563eb;">نفر</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- مجموع مهمان‌ها --}}
                <div class="col-xl-6 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-icon icon-guest">
                                <i class="la la-user-plus"></i>
                            </div>

                            <div class="stat-info">
                                <span class="stat-label">مجموع مهمان‌ها</span>
                                <span class="stat-value">{{ $totals['guests'] ?? 0 }}</span>
                                <span class="stat-sub" style="color:#9333ea;">نفر</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            {{-- =========================================================
                وضعیت اتاق‌ها
            ========================================================== --}}
            <div class="row mb-4">

                {{-- مجموع اتاق‌ها --}}
                <div class="col-xl-4 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-icon icon-room">
                                <i class="la la-building"></i>
                            </div>

                            <div class="stat-info">
                                <span class="stat-label">مجموع اتاق‌ها</span>
                                <span class="stat-value">{{ $roomTotals['total'] ?? 0 }}</span>
                                <span class="stat-sub" style="color:#059669;">اتاق</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- اتاق‌های پر --}}
                <div class="col-xl-4 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-icon icon-full">
                                <i class="la la-lock"></i>
                            </div>

                            <div class="stat-info">
                                <span class="stat-label">اتاق‌های تکمیل ظرفیت</span>
                                <span class="stat-value">{{ $roomTotals['full'] ?? 0 }}</span>
                                <span class="stat-sub" style="color:#dc2626;">ظرفیت کاملاً پر</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- اتاق‌های دارای ظرفیت --}}
                <div class="col-xl-4 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-icon icon-available">
                                <i class="la la-check-square"></i>
                            </div>

                            <div class="stat-info">
                                <span class="stat-label">اتاق‌های دارای ظرفیت</span>
                                <span class="stat-value">{{ $roomTotals['available'] ?? 0 }}</span>
                                <span class="stat-sub" style="color:#b45309;">قابل استفاده</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>





            {{-- =========================================================
                جدول گزارش اقامت‌کنندگان و مهمان‌ها
            ========================================================== --}}
            <div class="card custom-card mb-4">
                <div class="card-header">
                    <div class="title-group">
                        <i class="la la-users"></i>
                        <span>
                            گزارش اقامت‌کنندگان و مهمان‌ها
                            ({{ $totalResults ?? 0 }} نتیجه)
                        </span>
                    </div>

                    <span class="font-small-2 text-muted">
                        مجموع افراد حاضر: {{ $totals['people'] ?? (($totals['residents'] ?? 0) + ($totals['guests'] ?? 0)) }}
                    </span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table report-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام</th>
                                    <th>نوع</th>
                                    <th>کد / شماره</th>
                                    <th>اتاق</th>
                                    <th>ظرفیت اتاق</th>
                                    <th>تاریخ ورود</th>
                                    <th>وضعیت</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse(($items ?? []) as $index => $item)
                                    @php
                                        $type = $item['type'] ?? 'resident';
                                        $roomCapacity = $item['room_capacity'] ?? 0;
                                        $roomOccupied = $item['room_occupied'] ?? 0;
                                        $isFull = $roomCapacity > 0 && $roomOccupied >= $roomCapacity;
                                        $isEmpty = $roomOccupied == 0;
                                        $roomPercent = $roomCapacity > 0
                                            ? min(100, round(($roomOccupied / $roomCapacity) * 100))
                                            : 0;
                                    @endphp

                                    <tr>
                                        <td>{{ $index + 1 }}</td>

                                        <td>
                                            <div class="person-info">
                                                <div class="avatar-circle">
                                                    {{ mb_substr($item['name'] ?? '', 0, 1) }}
                                                </div>

                                                <div>
                                                    <span class="person-name">
                                                        {{ $item['name'] ?? '-' }}
                                                    </span>

                                                    <span class="person-code">
                                                        {{ $item['phone'] ?? '' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            @if($type == 'guest')
                                                <span class="status-badge status-guest">
                                                    <i class="la la-user-plus"></i>
                                                    مهمان
                                                </span>
                                            @else
                                                <span class="status-badge status-resident">
                                                    <i class="la la-user"></i>
                                                    اقامت‌کننده
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $item['code'] ?? ($item['resident_code'] ?? ($item['guest_code'] ?? '-')) }}
                                        </td>

                                        <td>
                                            <strong>{{ $item['room_number'] ?? '-' }}</strong>
                                        </td>

                                        <td>
                                            <div class="capacity-progress">
                                                <div class="progress">
                                                    <div class="progress-bar"
                                                         role="progressbar"
                                                         style="width: {{ $roomPercent }}%;">
                                                    </div>
                                                </div>

                                                <div class="capacity-text">
                                                    {{ $roomOccupied }} از {{ $roomCapacity }} نفر
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            {{ $item['check_in_date'] ?? ($item['entry_date'] ?? '-') }}
                                        </td>

                                        <td>
                                            @if($isFull)
                                                <span class="status-badge room-full">
                                                    <i class="la la-lock"></i>
                                                    ظرفیت پر
                                                </span>
                                            @elseif($isEmpty)
                                                <span class="status-badge room-available">
                                                    <i class="la la-check-circle"></i>
                                                    خالی
                                                </span>
                                            @else
                                                <span class="status-badge room-partial">
                                                    <i class="la la-adjust"></i>
                                                    دارای ظرفیت
                                                </span>
                                            @endif
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="la la-info-circle"></i>
                                            نتیجه‌ای یافت نشد
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-body border-top d-flex justify-content-between align-items-center flex-wrap" style="gap: 10px;">
                    <span class="font-small-2 text-muted">
                        نمایش {{ $totalResults ?? 0 }} نتیجه
                    </span>

                    <div class="d-flex align-items-center" style="gap: 15px;">
                        <span class="font-small-2 text-muted">
                            اقامت‌کنندگان:
                            <strong style="color:#2563eb;">
                                {{ $totals['residents'] ?? 0 }}
                            </strong>
                        </span>

                        <span class="font-small-2 text-muted">
                            مهمان‌ها:
                            <strong style="color:#9333ea;">
                                {{ $totals['guests'] ?? 0 }}
                            </strong>
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

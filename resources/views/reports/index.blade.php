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

        {{-- بخش اول: انتخاب نوع گزارش --}}
        <div class="row mb-3">
            <div class="col-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <i class="la la-filter"></i>
                        <span>نوع گزارش</span>
                    </div>
                    <div class="card-body d-flex flex-wrap align-items-center">
                        @foreach($reportTypes as $key => $type)
                            <a href="{{ route('reports.index', ['type' => $key]) }}" class="btn btn-sm btn-export mb-2 {{ $selectedType === $key ? 'active' : '' }}" style="background: {{ $selectedType === $key ? '#1a56db' : '#ffffff' }}; color: {{ $selectedType === $key ? '#ffffff' : '#475569' }}; border-color: {{ $selectedType === $key ? '#1a56db' : '#cbd5e1' }}; margin-left: 5px;">
                                {{ $type['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- بخش دوم: کارت‌های خلاصه گزارش --}}
        <div class="row mb-2">
            @foreach($report['summary'] as $summary)
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card stat-card">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-small-3 d-block mb-1">{{ $summary['title'] }}</span>
                                <h2 class="font-weight-bold mb-1" style="color: #1e293b;">{{ $summary['value'] }}</h2>
                                <span class="font-small-2 text-muted font-weight-600">{{ $summary['detail'] }}</span>
                            </div>
                            <div class="stat-icon" style="background: {{ $summary['bg'] }}; color: {{ $summary['color'] }};"><i class="{{ $summary['icon'] }}"></i></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- بخش سوم: جدول گزارش انتخاب شده --}}
        <div class="card custom-card mb-4">
            <div class="card-header">
                <i class="la la-table"></i>
                <span>{{ $reportTypes[$selectedType]['label'] }} - جزئیات</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                @foreach($report['tableHeaders'] as $header)
                                    <th>{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($report['tableRows'] as $row)
                                <tr>
                                    <td class="font-weight-600">{{ $row['primary'] }}</td>
                                    <td>{{ $row['secondary'] }}</td>
                                    <td>{{ $row['status'] }}</td>
                                    <td>{{ $row['meta'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- بخش چهارم: کارت‌های تکمیلی گزارش --}}
        <div class="row mb-4">
            @foreach($report['detailCards'] as $card)
                <div class="col-md-6 mb-3">
                    <div class="card custom-card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1" style="font-weight: 700; color: #1f2937;">{{ $card['title'] }}</h6>
                                    <p class="mb-0 text-muted" style="font-size: 13px;">{{ $card['hint'] }}</p>
                                </div>
                                <div class="badge badge-pill badge-primary" style="background: #e0f2fe; color: #0369a1; padding: 8px 12px; font-size: 14px; font-weight: 700; border-radius: 12px;">{{ $card['value'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- بخش پنجم: خروجی گزارش‌ها --}}
        <div class="card custom-card mb-4">
            <div class="card-header">
                <i class="la la-download"></i>
                <span>خروجی گزارش (دیمو)</span>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center">
                    <button class="btn btn-export"><i class="la la-file-pdf-o text-danger"></i> PDF {{ $reportTypes[$selectedType]['label'] }}</button>
                    <button class="btn btn-export"><i class="la la-file-excel-o text-success"></i> Excel {{ $reportTypes[$selectedType]['label'] }}</button>
                    <button class="btn btn-export"><i class="la la-file-text-o text-info"></i> خلاصه {{ $reportTypes[$selectedType]['label'] }}</button>
                    <button class="btn btn-export"><i class="la la-print text-secondary"></i> چاپ خلاصه</button>
                </div>
                <div class="alert mt-3 mb-0 py-2 font-small-3 d-flex align-items-center" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; border-radius: 8px;">
                    <i class="la la-info-circle ml-2" style="font-size: 18px;"></i>
                    <span>در نسخه نهایی، داده‌های گزارش از دیتابیس بارگذاری می‌شوند و اینجا فقط نمایش دمو است.</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
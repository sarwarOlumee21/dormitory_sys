@extends('layouts.generalLayouts')

@section('content')

<div class="row" style="direction: rtl;">
    <div class="col-12">

        {{-- بنر بالایی صفحه با استایل مدرن، مینیمال و یکپارچه --}}
        <div class="top-banner mb-4" style="border-radius: 12px; padding: 20px; color: #ffffff;">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <div class="banner-icon ml-3" style="background: rgba(255,255,255,0.2); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="la la-users text-white" style="font-size:22px;"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-1 font-weight-bold">مدیریت و لیست مهمانان</h5>
                        <p class="mb-0" style="color:rgba(255,255,255,.75); font-size:13px;">مشاهده وضعیت حضور، ثبت خروج و تاریخچه رفت‌وامد مهمانان</p>
                    </div>
                </div>
                <div>
                    <a href="{{ route('visitors.register') }}" class="btn btn-white text-primary font-weight-bold px-4" style="background: #ffffff; border-radius: 8px; border: none; height: 40px; display: flex; align-items: center;">
                        <i class="la la-plus ml-1" style="font-size: 16px;"></i> ثبت مهمان جدید
                    </a>
                </div>
            </div>
        </div>

        {{-- استایل‌های اختصاصی پالت رنگی سازمانی آبی --}}
        <style>
            .custom-card {
                background: #ffffff;
                border: 1px solid #e2e8f0 !important;
                border-radius: 12px !important;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                margin-bottom: 25px;
                overflow: hidden;
            }
            .table thead th {
                background-color: #1a56db !important;
                color: #ffffff !important;
                font-weight: 600;
                font-size: 13px;
                border: none !important;
                padding: 14px 10px;
            }
            .table tbody td {
                padding: 12px 10px;
                vertical-align: middle;
                font-size: 13px;
                color: #334155;
                border-bottom: 1px solid #f1f5f9 !important;
            }
            .badge-custom-blue { background: rgba(26, 86, 219, 0.1); color: #1a56db; font-weight: 600; border-radius: 6px; padding: 5px 10px; }
            .badge-custom-green { background: rgba(4, 120, 87, 0.1); color: #047857; font-weight: 600; border-radius: 6px; padding: 5px 10px; }
            .badge-custom-slate { background: rgba(100, 116, 139, 0.1); color: #64748b; font-weight: 600; border-radius: 6px; padding: 5px 10px; }
            
            .btn-action-out {
                background: #047857;
                color: #ffffff;
                border: none;
                border-radius: 6px;
                padding: 6px 12px;
                font-size: 12px;
                font-weight: 600;
                transition: background 0.2s;
            }
            .btn-action-out:hover {
                background: #065f46;
                color: #ffffff;
            }
        </style>

        {{-- جدول نمایش داده‌ها درون کارد مینیمال --}}
        <div class="card custom-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام مهمان</th>
                            <th>ساکن میزبان</th>
                            <th>نمبر اتاق</th>
                            <th>تاریخ و ساعت ورود</th>
                            <th>تاریخ و ساعت خروج</th>
                            <th>وضعیت حضور</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- ردیف اول --}}
                        <tr>
                            <td>۱</td>
                            <td class="font-weight-bold">فاطمه nori</td>
                            <td>احمد نوری</td>
                            <td><span class="badge-custom-blue">A-12</span></td>
                            <td dir="ltr" class="text-right">1404/03/10 14:00</td>
                            <td class="text-muted">—</td>
                            <td><span class="badge-custom-blue"><i class="la la-sign-in"></i> داخل خوابگاه</span></td>
                            <td class="text-center">
                                <button class="btn btn-action-out"><i class="la la-sign-out"></i> ثبت خروج</button>
                            </td>
                        </tr>
                        {{-- ردیف دوم --}}
                        <tr>
                            <td>۲</td>
                            <td class="font-weight-bold">محمد رحیمی</td>
                            <td>علی رحیمی</td>
                            <td><span class="badge-custom-blue">B-07</span></td>
                            <td dir="ltr" class="text-right">1404/03/09 10:30</td>
                            <td dir="ltr" class="text-right">1404/03/09 18:00</td>
                            <td><span class="badge-custom-slate"><i class="la la-power-off"></i> خروج کرده</span></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary" style="border-radius: 6px;" title="مشاهده جزئیات"><i class="la la-eye"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-light d-flex align-items-center justify-content-between flex-wrap py-3" style="border-top: 1px solid #e2e8f0;">
                <span class="text-muted font-small-3">نمایش لیست فعال مهمانان</span>
                <span class="text-muted font-small-3">
                    <i class="la la-info-circle text-primary"></i> برای ثبت مهمان جدید از دکمه بالا استفاده کنید.
                </span>
            </div>
        </div>

    </div>
</div>

@endsection
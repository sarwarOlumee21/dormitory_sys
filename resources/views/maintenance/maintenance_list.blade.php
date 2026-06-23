@extends('layouts.generalLayouts')

@section('content')

<div class="row" style="direction: rtl;">
    <div class="col-12">

        {{-- بنر بالایی صفحه با استایل مدرن، مینیمال و یکپارچه --}}
        <div class="top-banner mb-4" style="border-radius: 12px; padding: 20px; color: #ffffff;">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <div class="banner-icon ml-3" style="background: rgba(255,255,255,0.2); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="la la-tools text-white" style="font-size:22px;"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-1 font-weight-bold">مدیریت و لیست درخواست‌ها</h5>
                        <p class="mb-0" style="color:rgba(255,255,255,.75); font-size:13px;">پیگیری وضعیت تعمیرات، خدمات نظافتی و شکایات ثبت شده در خوابگاه</p>
                    </div>
                </div>
                <div>
                    <a href="" class="btn btn-white text-primary font-weight-bold px-4" style="background: #ffffff; border-radius: 8px; border: none; height: 40px; display: flex; align-items: center;">
                        <i class="la la-plus ml-1" style="font-size: 16px;"></i> ثبت درخواست جدید
                    </a>
                </div>
            </div>
        </div>

        {{-- استایل‌های اختصاصی پالت رنگی سازمانی آبی و وضعیت‌ها --}}
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
            /* استایل نشان‌ها (Badges) */
            .badge-room { background: rgba(26, 86, 219, 0.1); color: #1a56db; font-weight: 600; border-radius: 6px; padding: 5px 10px; }
            
            /* اولویت‌ها */
            .badge-prio-danger { background: rgba(239, 68, 68, 0.1); color: #dc2626; font-weight: 600; border-radius: 6px; padding: 4px 8px; font-size: 12px; }
            .badge-prio-warning { background: rgba(245, 158, 11, 0.1); color: #d97706; font-weight: 600; border-radius: 6px; padding: 4px 8px; font-size: 12px; }
            .badge-prio-slate { background: rgba(100, 116, 139, 0.1); color: #475569; font-weight: 600; border-radius: 6px; padding: 4px 8px; font-size: 12px; }
            
            /* وضعیت‌ها */
            .badge-status-new { background: #1e40af; color: #ffffff; font-weight: 500; border-radius: 20px; padding: 3px 10px; font-size: 11px; }
            .badge-status-pending { background: #d97706; color: #ffffff; font-weight: 500; border-radius: 20px; padding: 3px 10px; font-size: 11px; }
            .badge-status-done { background: #047857; color: #ffffff; font-weight: 500; border-radius: 20px; padding: 3px 10px; font-size: 11px; }

            .btn-group .btn {
                border-radius: 6px !important;
                margin: 0 2px;
                padding: 5px 10px;
            }
        </style>

        {{-- جدول نمایش داده‌ها درون کارد مینیمال --}}
        <div class="card custom-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام گزارش‌دهنده / ساکن</th>
                            <th>نمبر اتاق</th>
                            <th>نوع درخواست</th>
                            <th>اولویت</th>
                            <th>تاریخ ثبت</th>
                            <th>وضعیت بررسی</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- ردیف اول --}}
                        <tr>
                            <td>۱</td>
                            <td class="font-weight-bold">احمد نوری</td>
                            <td><span class="badge-room">A-12</span></td>
                            <td>تعمیر برق</td>
                            <td><span class="badge-prio-danger"><i class="la la-exclamation-circle"></i> فوری</span></td>
                            <td dir="ltr" class="text-right">1404/03/11</td>
                            <td><span class="badge-status-pending">در حال بررسی</span></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-success" title="تغییر وضعیت به انجام شده"><i class="la la-check"></i></button>
                                    <button class="btn btn-outline-primary" title="مشاهده جزئیات"><i class="la la-eye"></i></button>
                                </div>
                            </td>
                        </tr>
                        {{-- ردیف دوم --}}
                        <tr>
                            <td>۲</td>
                            <td class="font-weight-bold">علی رحیمی</td>
                            <td><span class="badge-room">B-07</span></td>
                            <td>تعمیر آب</td>
                            <td><span class="badge-prio-warning">متوسط</span></td>
                            <td dir="ltr" class="text-right">1404/03/10</td>
                            <td><span class="badge-status-new">جدید</span></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" title="ویرایش درخواست"><i class="la la-edit"></i></button>
                                </div>
                            </td>
                        </tr>
                        {{-- ردیف سوم --}}
                        <tr>
                            <td>۳</td>
                            <td class="font-weight-bold">مدیریت</td>
                            <td><span class="badge-room">D-01</span></td>
                            <td>نظافت</td>
                            <td><span class="badge-prio-slate">عادی</span></td>
                            <td dir="ltr" class="text-right">1404/03/08</td>
                            <td><span class="badge-status-done"><i class="la la-check-circle"></i> انجام شده</span></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="مشاهده جزئیات"><i class="la la-eye"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-light d-flex align-items-center justify-content-between flex-wrap py-3" style="border-top: 1px solid #e2e8f0;">
                <span class="text-muted font-small-3">نمایش لیست کل درخواست‌های فنی و خدمات</span>
                <span class="text-muted font-small-3">
                    <i class="la la-info-circle text-primary"></i> برای ثبت درخواست جدید از دکمه بالا استفاده کنید.
                </span>
            </div>
        </div>

    </div>
</div>

@endsection
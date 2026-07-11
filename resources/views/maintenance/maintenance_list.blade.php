@extends('layouts.generalLayouts')

@section('content')

@vite(['resources/css/maintenance.css'])

<div class="row dir-rtl">
    <div class="col-12">

        {{-- بنر بالایی صفحه با استایل مدرن، مینیمال و یکپارچه --}}
        <div class="top-banner mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <div class="banner-icon ml-3">
                        <i class="la la-tools text-white"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-1 font-weight-bold">مدیریت و لیست درخواست‌ها</h5>
                            <p class="mb-0 banner-caption">پیگیری وضعیت تعمیرات، خدمات نظافتی و شکایات ثبت شده در خوابگاه</p>
                    </div>
                </div>
                <div>
                    <a href="" class="btn btn-white text-primary font-weight-bold px-4 btn-maintain-white">
                        <i class="la la-plus ml-1 icon-sm"></i> ثبت درخواست جدید
                    </a>
                </div>
            </div>
        </div>

        {{-- styles moved to public/css/maintenance.css --}}

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
            
            <div class="card-footer bg-light d-flex align-items-center justify-content-between flex-wrap py-3 card-footer-maintain">
                <span class="text-muted font-small-3">نمایش لیست کل درخواست‌های فنی و خدمات</span>
                <span class="text-muted font-small-3">
                    <i class="la la-info-circle text-primary"></i> برای ثبت درخواست جدید از دکمه بالا استفاده کنید.
                </span>
            </div>
        </div>

    </div>
</div>

@endsection
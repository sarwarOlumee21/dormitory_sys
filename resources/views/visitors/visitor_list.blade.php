@extends('layouts.generalLayouts')

@section('content')

@vite(['resources/css/visitors.css'])

<div class="row dir-rtl">
    <div class="col-12">

        {{-- بنر بالایی صفحه با استایل مدرن، مینیمال و یکپارچه --}}
        <div class="top-banner mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <div class="banner-icon ml-3">
                        <i class="la la-users text-white"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-1 font-weight-bold">مدیریت و لیست مهمانان</h5>
                        <p class="mb-0 banner-caption">مشاهده وضعیت حضور، ثبت خروج و تاریخچه رفت‌وامد مهمانان</p>
                    </div>
                </div>
                    <div>
                    <a href="{{ route('visitors.register') }}" class="btn btn-white text-primary font-weight-bold px-4 btn-maintain-white">
                        <i class="la la-plus ml-1 icon-sm"></i> ثبت مهمان جدید
                    </a>
                </div>
            </div>
        </div>

        {{-- styles moved to public/css/visitors.css --}}

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
                                    <button type="button" class="btn btn-outline-primary" title="مشاهده جزئیات"><i class="la la-eye"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-light d-flex align-items-center justify-content-between flex-wrap py-3 card-footer-maintain">
                <span class="text-muted font-small-3">نمایش لیست فعال مهمانان</span>
                <span class="text-muted font-small-3">
                    <i class="la la-info-circle text-primary"></i> برای ثبت مهمان جدید از دکمه بالا استفاده کنید.
                </span>
            </div>
        </div>

    </div>
</div>

@endsection
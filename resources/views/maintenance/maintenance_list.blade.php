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
                    <a href="{{ route('maintenance.request') }}" class="btn btn-white text-primary font-weight-bold px-4 btn-maintain-white">
                        <i class="la la-plus ml-1 icon-sm"></i> ثبت درخواست جدید
                    </a>
                </div>
            </div>
        </div>

        {{-- styles moved to public/css/maintenance.css --}}

        <div class="card custom-card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('maintenance.list') }}" class="row align-items-end">
                    <div class="col-md-4 mb-2">
                        <label class="font-small-3 text-muted mb-1">وضعیت درخواست</label>
                        <select name="status" class="form-control form-control-sm">
                            <option value="در حال پیگیری" {{ $selectedStatus == 'در حال پیگیری' ? 'selected' : '' }}>در حال پیگیری</option>
                            <option value="تکمیل شده" {{ $selectedStatus == 'تکمیل شده' ? 'selected' : '' }}>تکمیل شده</option>
                            <option value="رد شد" {{ $selectedStatus == 'رد شد' ? 'selected' : '' }}>رد شد</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="la la-filter ml-1"></i> اعمال فیلتر
                        </button>
                    </div>

                    <div class="col-md-2 mb-2">
                        <a href="{{ route('maintenance.list') }}" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="la la-refresh ml-1"></i> حذف
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- جدول نمایش داده‌ها درون کارد مینیمال --}}
        <div class="card custom-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام گزارش‌دهنده</th>
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
                        @foreach ($maintenanceRequests as $request)
                        
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td class="font-weight-bold">{{ $request->user->name ?? 'نام نامشخص' }}</td>
                            <td><span class="badge-room">{{ $request->room->room_number ?? 'اتاق نامشخص' }}</span></td>
                            <td>{{ $request->requestType->name ?? 'نوع نامشخص' }}</td>
                            <td><span class="badge-prio-danger"><i class="la la-exclamation-circle"></i> {{ $request->priority }}</span></td>
                            <td dir="ltr" class="text-left">{{ $request->created_at->format('Y-m-d H:i') }}</td>
                            <td><span class="badge-status-pending">{{$request->status}}</span></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('maintenance.show', $request) }}" class="btn btn-outline-primary" title="مشاهده جزئیات"><i class="la la-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach

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
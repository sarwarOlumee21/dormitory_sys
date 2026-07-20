@extends('layouts.generalLayouts')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-xl-8">
        <div class="page-banner">
            <div class="banner-icon">
                <i class="la la-user-circle text-white"></i>
            </div>
            <h5 class="mb-1 font-weight-bold" style="direction:rtl;">جزئیات ساکن</h5>
            <p class="mb-0 text-white-75" style="direction:rtl;">اطلاعات اصلی ساکن فقط برای نمایش نمایش داده می‌شود.</p>
        </div>


        <div class="card-soft p-4">
            <div class="table-responsive">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th class="text-start">کد ساکن</th>
                            <td>{{ $residentDetails->resident_code }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">نام کامل</th>
                            <td>{{ $residentDetails->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">نام پدر</th>
                            <td>{{ $residentDetails->father_name }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">شماره تلیفون</th>
                            <td>{{ $residentDetails->phone_number }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">شهر</th>
                            <td>{{ $residentDetails->city_name }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">نمبر اتاق</th>
                            <td>{{ $residentDetails->room->room_number ?? 'بدون اتاق' }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">وضعیت قرارداد</th>
                            <td>{{ $residentDetails->status }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">نام ضامن</th>
                            <td>{{ $residentDetails->guarantor_name }}</td>
                        </tr>
                        <tr>
                            <th class="text-start">تلفن ضامن</th>
                            <td>{{ $residentDetails->guarantor_phone }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('resident.list') }}" class="btn btn-secondary">
                    <i class="la la-arrow-left"></i> بازگشت به لیست
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

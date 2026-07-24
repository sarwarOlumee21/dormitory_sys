@extends('layouts.generalLayouts')

@section('content')

@vite(['resources/css/visitors.css'])

<div class="row justify-content-center dir-rtl">
    <div class="col-12">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        {{-- بنر بالایی صفحه با استایل مدرن، یکپارچه و آبی سازمانی --}}
        <div class="top-banner mb-4">
            <div class="d-flex align-items-center">
                <div class="banner-icon ml-3">
                    <i class="la la-user-plus text-white"></i>
                </div>
                <div>
                    <h5 class="text-white mb-1 font-weight-bold">ثبت و مدیریت اطلاعات مهمان</h5>
                    <p class="mb-0 banner-caption">اطلاعات بازدیدکنندگان و مهمانان مقیم خوابگاه را به صورت دقیق ثبت نمایید</p>
                </div>
            </div>
        </div>

        {{-- styles moved to public/css/visitors.css --}}

        <form action="{{ route('visitors.store') }}" method="POST">
            @csrf
            <div class="card custom-form-card">
                <div class="card-header">
                    <i class="la la-id-badge"></i>
                    <span>مشخصات و اطلاعات ورود مهمان</span>
                </div>
                <div class="card-body py-4">
                    <div class="row">
                        
                        <div class="col-md-6 form-group mb-4">
                            <label class="flabel"><i class="la la-user text-primary"></i> ساکن میزبان</label>
                            <select class="form-control" name="resident_id">
                                <option selected disabled>انتخاب ساکن میزبان</option>
                                @foreach ($residents as $resident)
                                    <option value="{{ $resident->id }}">{{ $resident->name }} - {{ $resident->room_id }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-4">
                            <label class="flabel"><i class="la la-user-plus text-primary"></i> نام کامل مهمان</label>
                            <input type="text" class="form-control" name="guest_name" placeholder="نام و نام خانوادگی مهمان">
                        </div>

                        <div class="col-md-6 form-group mb-4">
                            <label class="flabel"><i class="la la-phone text-primary"></i> شماره تماس</label>
                            <input type="text" class="form-control text-right" name="guest_phone" dir="ltr" placeholder="07xxxxxxxx">
                        </div>

                        <div class="col-md-6 form-group mb-4">
                            <label class="flabel"><i class="la la-id-card text-primary"></i> تذکره / کارت هویت</label>
                            <input type="text" class="form-control" name="guest_id_number" placeholder="شماره تذکره یا مدرک شناسایی">
                        </div>

                        <div class="col-md-4 form-group mb-4">
                            <label class="flabel"><i class="la la-calendar text-primary"></i> تاریخ و ساعت ورود</label>
                            <input type="datetime-local" class="form-control" name="check_in_at">
                        </div>

                        <div class="col-md-4 form-group mb-4">
                            <label class="flabel"><i class="la la-calendar-check-o text-primary"></i> تاریخ خروج پیش‌بینی شده</label>
                            <input type="datetime-local" class="form-control" name="check_out_at">
                        </div>

                        <div class="col-md-4 form-group mb-4">
                            <label class="flabel"><i class="la la-toggle-on text-primary"></i> انتخاب اتاق</label>
                            <select class="form-control" name="room_number">
                                <option selected disabled>انتخاب اتاق</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 form-group mb-4">
                            <label class="flabel"><i class="la la-sticky-note text-primary"></i> هدف از بازدید</label>
                            <input type="text" class="form-control" name="purpose" placeholder="دیدار خانوادگی، تحویل وسایل، پروژه‌های درسی و غیره...">
                        </div>

                    </div>

                    {{-- دکمه‌های عملیاتی پایین فرم کاملاً ست‌شده و تمیز --}}
                    <div class="d-flex align-items-center justify-content-end pt-3 mt-2 card-footer-maintain">
                        <button type="reset" class="btn btn-outline-secondary px-4 ml-2 btn-maintain-outline">
                            <i class="la la-close"></i> لغو و پاکسازی
                        </button>
                        <button type="submit" class="btn btn-primary px-4 btn-maintain-primary">
                            <i class="la la-check-square"></i> ثبت اطلاعات مهمان
                        </button>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>

@endsection
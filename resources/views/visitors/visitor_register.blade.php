@extends('layouts.generalLayouts')

@section('content')

<div class="row justify-content-center" style="direction: rtl;">
    <div class="col-12">

        {{-- بنر بالایی صفحه با استایل مدرن، یکپارچه و آبی سازمانی --}}
        <div class="top-banner mb-4" style="border-radius: 12px; padding: 20px; color: #ffffff;">
            <div class="d-flex align-items-center">
                <div class="banner-icon ml-3" style="background: rgba(255,255,255,0.2); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="la la-user-plus text-white" style="font-size:22px;"></i>
                </div>
                <div>
                    <h5 class="text-white mb-1 font-weight-bold">ثبت و مدیریت اطلاعات مهمان</h5>
                    <p class="mb-0" style="color:rgba(255,255,255,.75); font-size:13px;">اطلاعات بازدیدکنندگان و مهمانان مقیم خوابگاه را به صورت دقیق ثبت نمایید</p>
                </div>
            </div>
        </div>

        {{-- استایل‌های یکپارچه و مشترک سیستم --}}
        <style>
            .custom-form-card {
                background: #ffffff;
                border: 1px solid #e2e8f0 !important;
                border-radius: 12px !important;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
                margin-bottom: 25px;
                overflow: hidden;
            }
            .custom-form-card .card-header {
                background: #f8fafc;
                border-bottom: 1px solid #e2e8f0;
                padding: 15px 20px;
                font-weight: bold;
                color: #1e293b;
                display: flex;
                align-items: center;
            }
            .custom-form-card .card-header i {
                font-size: 20px;
                color: #1a56db;
                margin-left: 10px;
            }
            .form-control {
                border-radius: 8px !important;
                border: 1px solid #cbd5e1 !important;
                padding: 10px 12px;
                transition: all 0.2s;
                background-color: #ffffff !important;
            }
            .form-control:focus {
                border-color: #1a56db !important;
                box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.1) !important;
            }
            .flabel {
                font-weight: 600;
                color: #475569;
                font-size: 13px;
                margin-bottom: 8px;
                display: block;
            }
            .flabel i {
                margin-left: 4px;
            }
        </style>

        <form>
            <div class="card custom-form-card">
                <div class="card-header">
                    <i class="la la-id-badge"></i>
                    <span>مشخصات و اطلاعات ورود مهمان</span>
                </div>
                <div class="card-body py-4">
                    <div class="row">
                        
                        <div class="col-md-6 form-group mb-4">
                            <label class="flabel"><i class="la la-user text-primary"></i> ساکن میزبان</label>
                            <select class="form-control">
                                <option selected disabled>انتخاب ساکن میزبان</option>
                                @foreach ($residents as $resident)
                                    <option value="{{ $resident->id }}">{{ $resident->name }} - {{ $resident->room_id }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-4">
                            <label class="flabel"><i class="la la-user-plus text-primary"></i> نام کامل مهمان</label>
                            <input type="text" class="form-control" placeholder="نام و نام خانوادگی مهمان">
                        </div>

                        <div class="col-md-6 form-group mb-4">
                            <label class="flabel"><i class="la la-phone text-primary"></i> شماره تماس</label>
                            <input type="text" class="form-control text-right" dir="ltr" placeholder="07xxxxxxxx">
                        </div>

                        <div class="col-md-6 form-group mb-4">
                            <label class="flabel"><i class="la la-id-card text-primary"></i> تذکره / کارت هویت</label>
                            <input type="text" class="form-control" placeholder="شماره تذکره یا مدرک شناسایی">
                        </div>

                        <div class="col-md-4 form-group mb-4">
                            <label class="flabel"><i class="la la-calendar text-primary"></i> تاریخ و ساعت ورود</label>
                            <input type="datetime-local" class="form-control">
                        </div>

                        <div class="col-md-4 form-group mb-4">
                            <label class="flabel"><i class="la la-calendar-check-o text-primary"></i> تاریخ خروج پیش‌بینی شده</label>
                            <input type="datetime-local" class="form-control">
                        </div>

                        <div class="col-md-4 form-group mb-4">
                            <label class="flabel"><i class="la la-toggle-on text-primary"></i> وضعیت حضور</label>
                            <select class="form-control">
                                <option selected>داخل خوابگاه</option>
                                <option>خروج کرده</option>
                            </select>
                        </div>

                        <div class="col-12 form-group mb-4">
                            <label class="flabel"><i class="la la-sticky-note text-primary"></i> هدف از بازدید</label>
                            <input type="text" class="form-control" placeholder="دیدار خانوادگی، تحویل وسایل، پروژه‌های درسی و غیره...">
                        </div>

                    </div>

                    {{-- دکمه‌های عملیاتی پایین فرم کاملاً ست‌شده و تمیز --}}
                    <div class="d-flex align-items-center justify-content-end pt-3 mt-2" style="border-top: 1px solid #f1f5f9;">
                        <button type="reset" class="btn btn-outline-secondary px-4 ml-2" style="border-radius: 8px; height: 40px; font-size: 14px;">
                            <i class="la la-close"></i> لغو و پاکسازی
                        </button>
                        <button type="submit" class="btn btn-primary px-4" style="background: #1a56db; border: none; border-radius: 8px; height: 40px; font-size: 14px; font-weight: 600;">
                            <i class="la la-check-square"></i> ثبت اطلاعات مهمان
                        </button>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>

@endsection
@extends('layouts.generalLayouts')

@section('content')

<div class="row justify-content-center" style="direction: rtl;">
    <div class="col-12">

        {{-- بنر بالایی صفحه با استایل مدرن، یکپارچه و آبی سازمانی --}}
        <div class="top-banner mb-4" style="border-radius: 12px; padding: 20px; color: #ffffff;">
            <div class="d-flex align-items-center">
                <div class="banner-icon ml-3" style="background: rgba(255,255,255,0.2); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="la la-wrench text-white" style="font-size:22px;"></i>
                </div>
                <div>
                    <h5 class="text-white mb-1 font-weight-bold">ثبت درخواست تعمیرات و شکایات</h5>
                    <p class="mb-0" style="color:rgba(255,255,255,.75); font-size:13px;">مشکلات فنی، نظافتی یا شکایات مربوط به اتاق‌ها و خدمات خوابگاه را ثبت کنید</p>
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
                    <i class="la la-tools"></i>
                    <span>جزئیات و مشخصات درخواست</span>
                </div>
                <div class="card-body py-4">
                    <div class="row">
                        
                        <div class="col-md-6 form-group mb-4">
                            <label class="flabel"><i class="la la-user text-primary"></i> ساکن / گزارش‌دهنده</label>
                            <select class="form-control">
                                <option>احمد نوری — A-12</option>
                                <option>علی رحیمی — B-07</option>
                                <option>مدیریت — عمومی</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-4">
                            <label class="flabel"><i class="la la-home text-primary"></i> نمبر اتاق</label>
                            <input type="text" class="form-control" placeholder="مثلاً A-12" value="A-12">
                        </div>

                        <div class="col-md-6 form-group mb-4">
                            <label class="flabel"><i class="la la-tags text-primary"></i> نوع درخواست / مشکل</label>
                            <select class="form-control">
                                <option>تعمیر برق</option>
                                <option>تعمیر آب و لوله‌کشی</option>
                                <option>تعمیر قفل و در</option>
                                <option>خدمات نظافت</option>
                                <option>شکایت و گزارش</option>
                                <option>سایر موارد</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-4">
                            <label class="flabel"><i class="la la-flag text-primary"></i> میزان اولویت</label>
                            <select class="form-control">
                                <option>عادی</option>
                                <option selected>متوسط</option>
                                <option>فوری و اضطراری</option>
                            </select>
                        </div>

                        <div class="col-12 form-group mb-4">
                            <label class="flabel"><i class="la la-align-right text-primary"></i> شرح کامل مشکل</label>
                            <textarea class="form-control" rows="4" placeholder="لطفاً جزئیات مشکل یا خسارت وارده را به‌طور کامل در این بخش شرح دهید..."></textarea>
                        </div>

                        <div class="col-md-6 form-group mb-4 mb-md-0">
                            <label class="flabel"><i class="la la-toggle-on text-primary"></i> وضعیت بررسی</label>
                            <select class="form-control">
                                <option selected>جدید</option>
                                <option>در حال بررسی</option>
                                <option>انجام شده</option>
                            </select>
                        </div>

                    </div>

                    {{-- دکمه‌های عملیاتی فرم کاملاً ست‌شده و تمیز --}}
                    <div class="d-flex align-items-center justify-content-end pt-3 mt-4" style="border-top: 1px solid #f1f5f9;">
                        <button type="reset" class="btn btn-outline-secondary px-4 ml-2" style="border-radius: 8px; height: 40px; font-size: 14px;">
                            <i class="la la-close"></i> لغو و انصراف
                        </button>
                        <button type="submit" class="btn btn-primary px-4" style="background: #1a56db; border: none; border-radius: 8px; height: 40px; font-size: 14px; font-weight: 600;">
                            <i class="la la-check-square"></i> ثبت و ارسال درخواست
                        </button>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>

@endsection
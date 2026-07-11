@extends('layouts.generalLayouts')

@section('content')

@vite(['resources/css/maintenance.css'])

<div class="row justify-content-center dir-rtl">
    <div class="col-12">

        {{-- بنر بالایی صفحه با استایل مدرن، یکپارچه و آبی سازمانی --}}
        <div class="top-banner mb-4">
            <div class="d-flex align-items-center">
                <div class="banner-icon ml-3">
                    <i class="la la-wrench text-white"></i>
                </div>
                <div>
                    <h5 class="text-white mb-1 font-weight-bold">ثبت درخواست تعمیرات و شکایات</h5>
                    <p class="mb-0 banner-caption">مشکلات فنی، نظافتی یا شکایات مربوط به اتاق‌ها و خدمات خوابگاه را ثبت کنید</p>
                </div>
            </div>
        </div>

        {{-- styles moved to public/css/maintenance.css --}}

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
                    <div class="d-flex align-items-center justify-content-end pt-3 mt-4 card-footer-maintain">
                        <button type="reset" class="btn btn-outline-secondary px-4 ml-2 btn-maintain-outline">
                            <i class="la la-close"></i> لغو و انصراف
                        </button>
                        <button type="submit" class="btn btn-primary px-4 btn-maintain-primary" >
                            <i class="la la-check-square"></i> ثبت و ارسال درخواست
                        </button>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>

@endsection
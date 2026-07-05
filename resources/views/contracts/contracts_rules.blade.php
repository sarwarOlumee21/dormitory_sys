@extends('layouts.generalLayouts')

@section('content')

<div class="row justify-content-center" style="direction: rtl;">
    <div class="col-12">

        {{-- بنر بالایی صفحه با استایل مدرن و یکپارچه --}}
        <div class="top-banner mb-4" style="background: #1a56db; border-radius: 12px; padding: 20px; color: #ffffff;">
            <div class="d-flex align-items-center">
                <div class="banner-icon ml-3" style="background: rgba(255,255,255,0.2); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; text-align: center; line-height: 45px;">
                    <i class="la la-shield text-white" style="font-size:22px; vertical-align: middle;"></i>
                </div>
                <div>
                    <h5 class="text-white mb-1 font-weight-bold">تنظیم و ثبت قوانین قرارداد</h5>
                    <p class="mb-0" style="color:rgba(255,255,255,.75); font-size:13px;">متن پیش‌فرض قوانین را وارد کنید تا در صفحه ثبت قرارداد بارگذاری شود</p>
                </div>
            </div>
        </div>

        {{-- استایل مشترک و یکپارچه کاردها --}}
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
                padding: 12px;
                transition: all 0.2s;
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
            }
        </style>

        <form method="post" action="{{ route('contracts.rules.save') }}">
            @csrf

            {{-- کارد اصلی: فرم ورود قوانین --}}
            <div class="card custom-form-card">
                <div class="card-header">
                    <i class="la la-edit"></i>
                    <span>ورود متن قوانین</span>
                </div>
                <div class="card-body py-4">
                    <div class="form-group mb-4">
                        <label class="flabel" for="contractRulesTextarea">متن قوانین قرارداد</label>
                        <textarea id="contractRulesTextarea" name="contract_rules" rows="12" class="form-control" placeholder="قوانین کلی و مفاد قرارداد را اینجا بنویسید..." style="resize: vertical;">{{ old('contract_rules', $rulesText ?? '') }}</textarea>
                        <small class="form-text text-muted mt-2">
                            <i class="la la-info-circle"></i> این متن به صورت خودکار به عنوان پیش‌نویس در «مرحله ۵» فرم ثبت قرارداد جدید لود خواهد شد.
                        </small>
                    </div>

                    {{-- دکمه‌های عملیاتی هماهنگ --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-between pt-2" style="border-top: 1px solid #f1f5f9;">
                        <small class="text-muted mb-2 mb-md-0">تغییرات شما پس از ذخیره، روی قراردادهای جدید اعمال می‌شود.</small>
                        <div class="d-flex">
                            <a href="{{ route('contracts.register') }}" class="btn btn-outline-secondary px-4 ml-2" style="border-radius: 8px; height: 40px; font-size: 14px;">
                                <i class="la la-arrow-right"></i> بازگشت به ثبت قرارداد
                            </a>
                            <button type="submit" class="btn btn-primary px-4" style="background: #1a56db; border: none; border-radius: 8px; height: 40px; font-size: 14px;">
                                <i class="la la-save"></i> ذخیره قوانین
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </form>

    </div>
</div>

@endsection
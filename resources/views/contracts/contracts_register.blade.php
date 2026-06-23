@extends('layouts.generalLayouts')

@section('content')

<div class="row justify-content-center" style="direction: rtl;">
    <div class="col-12">

        {{-- بنر بالایی صفحه با استایل مدرن و یکپارچه --}}
        <div class="top-banner mb-4" style="border-radius: 12px; padding: 20px; color: #ffffff;">
            <div class="d-flex align-items-center">
                <div class="banner-icon ml-3" style="background: rgba(255,255,255,0.2); width: 45px; height: 45px; border-radius: 10px; d-flex: flex; align-items: center; justify-content: center; text-align: center; line-height: 45px;">
                    <i class="la la-file-text text-white" style="font-size:22px; vertical-align: middle;"></i>
                </div>
                <div>
                    <h5 class="text-white mb-1 font-weight-bold">ثبت قرارداد جدید</h5>
                    <p class="mb-0" style="color:rgba(255,255,255,.75); font-size:13px;">لطفاً اطلاعات قرارداد ساکن را با دقت پُر و تنظیم کنید</p>
                </div>
            </div>
        </div>

        {{-- بدنه اصلی فرم --}}
        <div class="form-outer">
            <form>

                {{-- استایل مشترک کاردها: کلاس custom-form-card --}}
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
                    .finput, .form-control {
                        border-radius: 8px !important;
                        border: 1px solid #cbd5e1 !important;
                        height: 44px;
                        padding: 0 12px;
                        transition: all 0.2s;
                    }
                    .finput:focus, .form-control:focus {
                        border-color: #1a56db !important;
                        box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.1) !important;
                    }
                    .flabel {
                        font-weight: 600;
                        color: #475569;
                        font-size: 13px;
                        margin-bottom: 8px;
                    }
                    .flabel i {
                        color: #64748b;
                        margin-left: 4px;
                    }
                </style>

                {{-- مرحله ۱: انتخاب ساکن --}}
                <div class="card custom-form-card">
                    <div class="card-header">
                        <i class="la la-search"></i>
                        <span>مرحله ۱: انتخاب ساکن</span>
                    </div>
                    <div class="card-body py-4">
                        <p class="text-muted font-small-3 mb-3">بر اساس کد شخص، اطلاعات به‌صورت خودکار پر می‌شود.</p>
                        <div class="row align-items-end">
                            <div class="col-lg-9 form-group mb-lg-0">
                                <label class="flabel" for="userSelect">کد و نام شخص</label>
                                <select class="finput w-100" id="userSelect">
                                    <option value="">— لطفاً یک شخص انتخاب کنید —</option>
                                    <option
                                        data-name="احمد نوری"
                                        data-father="محمد نوری"
                                        data-phone="0700123456"
                                        data-city="کابل"
                                        data-room="A-12"
                                        data-occupation="محصل"
                                        data-workphone="0799887766"
                                        data-location="پوهنتون کابل"
                                        data-guarantor-name="سید حامد"
                                        data-guarantor-father="سلیمان"
                                        data-guarantor-phone="0799123456"
                                        data-guarantor-occupation="کارمند بانک"
                                    >1001 — احمد نوری</option>
                                    <option
                                        data-name="علی رحیمی"
                                        data-father="عبدالرحیم"
                                        data-phone="0700554433"
                                        data-city="هرات"
                                        data-room="B-07"
                                        data-occupation="کارمند"
                                        data-workphone="0788112233"
                                        data-location="شرکت خصوصی"
                                        data-guarantor-name="مریم احمدی"
                                        data-guarantor-father="کرامت"
                                        data-guarantor-phone="0799001122"
                                        data-guarantor-occupation="معلم"
                                    >1002 — علی رحیمی</option>
                                </select>
                            </div>
                            <div class="col-lg-3 form-group mb-0">
                                <button type="button" class="btn btn-primary btn-block" style="background:#1a56db; border:none; border-radius:8px; height: 44px; font-size: 14px;" onclick="document.getElementById('userSelect').focus()">
                                    <i class="la la-search"></i> جستجو
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- پیش‌نمایش انتخاب‌شده (با همان استایل کادرها ولی ساده‌تر) --}}
                <div class="card custom-form-card">
                    <div class="card-header" style="background: #ffffff; padding: 12px 20px;">
                        <i class="la la-info-circle" style="color: #64748b;"></i>
                        <span style="font-size: 13px; color: #64748b;">پیش‌نمایش انتخاب‌شده</span>
                    </div>
                    <div id="userPreview" class="card-body text-center py-3 text-muted">
                        <span><i class="la la-meh-o"></i> هنوز شخصی انتخاب نشده است</span>
                    </div>
                </div>

                {{-- ردیف دو ستونه برای مراحل ۲، ۳ و ۴ --}}
                <div class="row">
                    {{-- سمت راست: اطلاعات شخصی و شغلی --}}
                    <div class="col-lg-8">

                        {{-- مرحله ۲: اطلاعات شخصی --}}
                        <div class="card custom-form-card">
                            <div class="card-header">
                                <i class="la la-id-card"></i>
                                <span>مرحله ۲: اطلاعات شخصی</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="flabel" for="name"><i class="la la-user"></i> نام کامل</label>
                                        <input type="text" id="name" class="finput w-100 bg-light" placeholder="نام کامل" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="flabel" for="father_name"><i class="la la-male"></i> نام پدر</label>
                                        <input type="text" id="father_name" class="finput w-100 bg-light" placeholder="نام پدر" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="flabel" for="phone_number"><i class="la la-phone"></i> شماره تلیفون</label>
                                        <input type="text" id="phone_number" class="finput w-100 bg-light" placeholder="شماره تماس" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="flabel" for="city_name"><i class="la la-map-marker"></i> شهر</label>
                                        <input type="text" id="city_name" class="finput w-100 bg-light" placeholder="نام شهر" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- مرحله ۳: اطلاعات شغلی و اتاق --}}
                        <div class="card custom-form-card">
                            <div class="card-header">
                                <i class="la la-briefcase"></i>
                                <span>مرحله ۳: اطلاعات شغلی و اتاق</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="flabel" for="room_number"><i class="la la-home"></i> نمبر اتاق</label>
                                        <input type="text" id="room_number" class="finput w-100 bg-light" placeholder="نمبر اتاق" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="flabel" for="occupation"><i class="la la-graduation-cap"></i> شغل</label>
                                        <input type="text" id="occupation" class="finput w-100 bg-light" placeholder="شغل" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="flabel" for="work_phone"><i class="la la-phone-square"></i> شماره محل کار</label>
                                        <input type="text" id="work_phone" class="finput w-100 bg-light" placeholder="شماره محل کار" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="flabel" for="occupation_location"><i class="la la-map-pin"></i> موقعیت شغل</label>
                                        <input type="text" id="occupation_location" class="finput w-100 bg-light" placeholder="موقعیت شغل" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card custom-form-card">
                            <div class="card-header">
                                <i class="la la-user-secret"></i>
                                <span>اطلاعات ضامن</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="flabel" for="guarantor_name"><i class="la la-user"></i> نام ضامن</label>
                                        <input type="text" id="guarantor_name" name="guarantor_name" class="finput w-100 bg-light" placeholder="نام ضامن" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="flabel" for="guarantor_father_name"><i class="la la-male"></i> نام پدر ضامن</label>
                                        <input type="text" id="guarantor_father_name" name="guarantor_father_name" class="finput w-100 bg-light" placeholder="نام پدر ضامن" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="flabel" for="guarantor_phone"><i class="la la-phone"></i> تلفن ضامن</label>
                                        <input type="text" id="guarantor_phone" name="guarantor_phone" class="finput w-100 bg-light" placeholder="شماره تلفن ضامن" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="flabel" for="guarantor_occupation"><i class="la la-briefcase"></i> موقعیت شغلی ضامن</label>
                                        <input type="text" id="guarantor_occupation" name="guarantor_occupation" class="finput w-100 bg-light" placeholder="موقعیت شغلی ضامن" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- سمت چپ: جزئیات قرارداد (Sidebar) --}}
                    <div class="col-lg-4">
                        {{-- مرحله ۴: جزئیات قرارداد --}}
                        <div class="card custom-form-card sticky-top" style="top: 20px;">
                            <div class="card-header">
                                <i class="la la-calendar"></i>
                                <span>مرحله ۴: جزئیات قرارداد</span>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label class="flabel"><i class="la la-calendar-check-o"></i> تاریخ قرارداد</label>
                                    <input type="date" class="finput w-100">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="flabel"><i class="la la-toggle-on"></i> وضعیت قرارداد</label>
                                    <select class="finput w-100" name="contract_status" id="contract_status">
                                        <option selected>فعال</option>
                                        <option>غیرفعال</option>
                                        <option>در انتظار</option>
                                    </select>
                                </div>
                                <hr class="my-3" style="border-color: #e2e8f0;">
                                <h6 class="font-weight-bold font-small-3 mb-3" style="color: #1a56db;">
                                    <i class="la la-money"></i> پرداخت اجاره
                                </h6>
                                <div class="form-group mb-3">
                                    <label class="flabel" for="contract_amount">اصل مبلغ قرارداد (افغانی)</label>
                                    <input type="number" id="contract_amount" name="contract_amount" class="finput w-100" placeholder="مثلاً 45000" min="0" step="100">
                                </div>
                                <div class="alert alert-warning mt-3 mb-0 py-2 font-small-3" role="alert" style="border-radius: 8px; background: #fffbeb; border: 1px solid #fef3c7; color: #b45309;">
                                    <i class="la la-lightbulb-o"></i> پس از انتخاب ساکن، فیلدهای سمت راست به‌طور خودکار پر می‌شوند.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- مرحله ۶: متن قرارداد و قوانین --}}
                <div class="card custom-form-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="la la-shield"></i>
                            <span>مرحله ۵: قرارداد و قوانین</span>
                        </div>
                        <span class="badge badge-light px-3 py-1 font-small-2" style="border-radius: 20px; color: #64748b; background: #f1f5f9;">پیش‌نویس</span>
                    </div>
                    <div class="card-body">
                        
                        @if(!empty($storedRules))
                            <div class="alert alert-neutral my-2 p-3" style="border-radius: 10px; background: #f8fafc; border: 1px solid #e2e8f0;">
                                <div class="d-flex justify-content-between align-items-start flex-wrap">
                                    <div>
                                        <h6 class="font-weight-bold mb-1 text-dark" style="font-size: 14px;">قوانین قرارداد ثبت‌شده</h6>
                                        <p class="mb-0 text-muted font-small-3">این متن از صفحه ثبت قوانین بارگذاری شده است.</p>
                                    </div>
                                    <a href="{{ route('contracts.rules') }}" class="btn btn-sm btn-outline-primary mt-2" style="border-radius: 8px;">ویرایش قوانین</a>
                                </div>
                                <div class="mt-3 p-3 bg-white text-dark rounded" style="white-space: pre-wrap; word-break: break-word; border: 1px solid #e2e8f0; font-size: 13px;">
                                    {!! nl2br(e($storedRules)) !!}
                                </div>
                            </div>
                        @endif


                    </div>
                </div>

                {{-- بخش دکمه‌های عملیاتی انتهای فرم --}}
                <div class="card custom-form-card" style="background: #f8fafc; margin-bottom: 0;">
                    <div class="card-body d-flex justify-content-between align-items-center py-3">
                        <small class="text-muted"><i class="la la-info-circle text-success" style="font-size: 16px;"></i> قبل از ثبت، اطلاعات را یک‌بار مرور کنید.</small>
                        <div class="d-flex">
                            <button type="reset" class="btn btn-outline-secondary px-4 ml-2" style="border-radius:8px; height: 40px; font-size: 14px;">
                                لغو
                            </button>
                            <button type="submit" class="btn btn-primary px-4" style="background:#1a56db; border:none; border-radius:8px; height: 40px; font-size: 14px;">
                                <i class="la la-check-square-o"></i> ثبت قرارداد
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

{{-- اسکریپت‌ها بدون تغییر منطقی --}}
<script>
document.getElementById('userSelect').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const preview = document.getElementById('userPreview');

    const fields = {
        name: selected.dataset.name || '',
        father_name: selected.dataset.father || '',
        phone_number: selected.dataset.phone || '',
        city_name: selected.dataset.city || '',
        room_number: selected.dataset.room || '',
        occupation: selected.dataset.occupation || '',
        work_phone: selected.dataset.workphone || '',
        occupation_location: selected.dataset.location || '',
        guarantor_name: selected.dataset.guarantorName || '',
        guarantor_father_name: selected.dataset.guarantorFather || '',
        guarantor_phone: selected.dataset.guarantorPhone || '',
        guarantor_occupation: selected.dataset.guarantorOccupation || '',
    };

    Object.keys(fields).forEach(function (id) {
        const el = document.getElementById(id);
        if (el) el.value = fields[id];
    });

    if (this.value && fields.name) {
        preview.className = 'card-body text-right py-3';
        preview.innerHTML =
            '<div class="d-flex align-items-start justify-content-between flex-wrap">' +
                '<div style="min-width: 260px;">' +
                    '<div class="font-weight-bold text-dark mb-1" style="font-size: 15px;">' + fields.name + '</div>' +
                    '<small class="text-muted d-block mb-1">' +
                        '<i class="la la-male"></i> ولد: ' + (fields.father_name || '—') +
                        ' &nbsp;|&nbsp; <i class="la la-phone"></i> تماس: ' + (fields.phone_number || '—') +
                    '</small>' +
                    '<small class="text-muted d-block mb-1">' +
                        '<i class="la la-home"></i> اتاق: ' + (fields.room_number || '—') +
                        ' &nbsp;|&nbsp; <i class="la la-briefcase"></i> شغل: ' + (fields.occupation || '—') +
                    '</small>' +
                    '<small class="text-muted d-block">' +
                        '<i class="la la-user-secret"></i> ضامن: ' + (fields.guarantor_name || '—') +
                        ' | <i class="la la-phone"></i> ' + (fields.guarantor_phone || '—') +
                    '</small>' +
                '</div>' +
                '<span class="badge px-3 py-2" style="background: #e0e7ff; color: #4338ca; border-radius: 20px; font-weight: bold;">کد ساکن: ' + this.value + '</span>' +
            '</div>';
    } else {
        preview.className = 'card-body text-center py-3 text-muted';
        preview.innerHTML = '<span><i class="la la-info-circle"></i> هنوز شخصی انتخاب نشده است</span>';
    }
});

const contractTa = document.getElementById('contractTextarea');
const contractCount = document.getElementById('contractCount');

function updateContractTextCount() {
    if (contractTa && contractCount) {
        contractCount.textContent = contractTa.value.length.toLocaleString('fa-IR') + ' کاراکتر';
    }
}

if (contractTa && contractCount) {
    contractTa.addEventListener('input', updateContractTextCount);
    updateContractTextCount();
}

function contractInsert(str) {
    const s = contractTa.selectionStart;
    const e = contractTa.selectionEnd;
    contractTa.value = contractTa.value.slice(0, s) + str + contractTa.value.slice(e);
    contractTa.focus();
    contractTa.selectionStart = contractTa.selectionEnd = s + str.length;
    contractTa.dispatchEvent(new Event('input'));
}

function contractClear() {
    if (confirm('آیا مطمئن هستید که می‌خواهید متن قرارداد را پاک کنید؟')) {
        contractTa.value = '';
        contractTa.dispatchEvent(new Event('input'));
    }
}
</script>

@endsection
@extends('layouts.generalLayouts')

@section('content')

    <div class="row justify-content-center" style="direction: rtl;">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- بنر بالایی صفحه با استایل مدرن و یکپارچه --}}
            <div class="top-banner mb-4" style="border-radius: 12px; padding: 20px; color: #ffffff;">
                <div class="d-flex align-items-center">
                    <div class="banner-icon ml-3"
                        style="background: rgba(255,255,255,0.2); width: 45px; height: 45px; border-radius: 10px; d-flex: flex; align-items: center; justify-content: center; text-align: center; line-height: 45px;">
                        <i class="la la-file-text text-white" style="font-size:22px; vertical-align: middle;"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-1 font-weight-bold">ثبت قرارداد جدید</h5>
                        <p class="mb-0" style="color:rgba(255,255,255,.75); font-size:13px;">لطفاً اطلاعات قرارداد ساکن را
                            با دقت پُر و تنظیم کنید</p>
                    </div>
                </div>
            </div>

            {{-- بدنه اصلی فرم --}}
            <div class="form-outer">
                <form method="post" action="{{ route('contracts.store') }}">
                    @csrf
                    <style>
                        .custom-form-card {
                            background: #ffffff;
                            border: 1px solid #e2e8f0 !important;
                            border-radius: 12px !important;
                            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
                            margin-bottom: 25px;
                            overflow: hidden;
                        }

                        .card-header {
                            background: #f8fafc;
                            border-bottom: 1px solid #e2e8f0;
                            padding: 15px 20px;
                            font-weight: bold;
                            color: #1e293b;
                            display: flex;
                            align-items: center;
                        }

                        .card-header i {
                            font-size: 20px;
                            color: #1a56db;
                            margin-left: 10px;
                        }

                        .finput,
                        .form-control {
                            border-radius: 8px !important;
                            border: 1px solid #cbd5e1 !important;
                            height: 44px;
                            padding: 0 12px;
                        }

                        .flabel {
                            font-weight: 600;
                            color: #475569;
                            font-size: 13px;
                            margin-bottom: 8px;
                        }
                    </style>

                    <!-- 🔵 ONE BIG CARD -->
                    <div class="card custom-form-card">

                        <div class="card-header">
                            <i class="la la-file-text"></i>
                            <span>فرم قرارداد</span>
                        </div>

                        <div class="card-body">
                            <!-- جزئیات قرارداد -->
                            <div class="row">

                                <div class="col-lg-6 mb-3">
                                    <!-- <label class="flabel">تاریخ پایان قرارداد</label>
                                        <input type="date" class="finput w-100"> -->
                                    <label class="flabel">کد و نام شخص</label>
                                    <select class="finput w-100" id="userSelect" name="resident_id">
                                        <option value="">— لطفاً یک شخص انتخاب کنید —</option>
                                        @foreach($residents as $resident)
                                            <option value="{{ $resident->id }}">
                                                {{ $resident->id }} - {{ $resident->name }}
                                            </option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="flabel">تاریخ شروع قرارداد</label>
                                    <input type="date" name="contract_date" class="finput w-100">
                                </div>


                                <div class="col-lg-6 mb-3">
                                    <label class="flabel">مبلغ قرارداد (افغانی)</label>
                                    <input type="number" name="contract_amount" class="finput w-100" placeholder="45000">
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="flabel">شماره اتاق</label>
                                    <select class="finput w-100" name="room_id">

                                        <option>انتخاب کنید</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="flabel">توضیحات</label>
                                    <textarea class="finput w-100" placeholder="توضیحات" name="notes"></textarea>
                                </div>
                            </div>

                            <hr>

                            <!-- قوانین -->
                            @if(!empty($storedRules))
                                <div class="p-3 bg-light rounded">
                                    <h6>قوانین قرارداد</h6>
                                    <div style="white-space: pre-wrap;">
                                        {!! nl2br(e($storedRules)) !!}
                                    </div>
                                </div>
                            @endif

                        </div>

                        <!-- دکمه‌ها -->
                        <div class="card-body d-flex justify-content-between align-items-center"
                            style="background:#f8fafc; border-top:1px solid #e2e8f0;">
                            <small class="text-muted">قبل از ثبت، اطلاعات را مرور کنید</small>

                            <div>
                                <button type="reset" class="btn btn-outline-secondary">لغو</button>
                                <button type="submit" class="btn btn-primary">
                                    ثبت قرارداد
                                </button>
                            </div>
                        </div>

                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection


<!-- {{-- اسکریپت‌ها بدون تغییر منطقی --}}
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
</script> -->
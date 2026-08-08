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
                @livewire('resident-search-in-contract')
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
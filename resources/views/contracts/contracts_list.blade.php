@extends('layouts.generalLayouts')

@section('content')

<div class="row" style="direction: rtl;">
    <div class="col-12">

        {{-- بنر بالایی صفحه با استایل مدرن و مینیمال --}}
        <div class="top-banner mb-4" style="border-radius: 12px; padding: 20px; color: #ffffff;">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <div class="banner-icon ml-3" style="background: rgba(255,255,255,0.2); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="la la-file-text text-white" style="font-size:22px;"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-1 font-weight-bold">مدیریت و لیست قراردادها</h5>
                        <p class="mb-0" style="color:rgba(255,255,255,.75); font-size:13px;">مشاهده، فیلتر و مدیریت تمامی قراردادهای ثبت شده در سیستم</p>
                    </div>
                </div>
                <div>
                    <a href="{{ route('contracts.register') }}" class="btn btn-white text-primary font-weight-bold px-4" style="background: #ffffff; border-radius: 8px; border: none; height: 40px; display: flex; align-items: center;">
                        <i class="la la-plus ml-1" style="font-size: 16px;"></i> ثبت قرارداد جدید
                    </a>
                </div>
            </div>
        </div>

        {{-- بخش فیلترها (اصلاح رنگ و حذف خاکستری) --}}
        <div class="filter-box mb-4">
            <div class="row align-items-end">
                <div class="col-lg-3 col-md-6 form-group mb-3 mb-lg-0">
                    <label class="flabel" for="filterSearch">
                        <i class="la la-search text-primary"></i> جستجو کلمات کلیدی
                    </label>
                    <input type="text" id="filterSearch" class="form-control" placeholder="نام، کد قرارداد، اتاق، تلفن...">
                </div>
                <div class="col-lg-2 col-md-6 form-group mb-3 mb-lg-0">
                    <label class="flabel" for="filterStatus">
                        <i class="la la-toggle-on text-primary"></i> وضعیت قرارداد
                    </label>
                    <select id="filterStatus" class="form-control">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="فعال">فعال</option>
                        <option value="غيرفعال">غیرفعال</option>
                        <option value="در انتظار">در انتظار</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6 form-group mb-3 mb-md-0">
                    <label class="flabel" for="filterCity">
                        <i class="la la-map-marker text-primary"></i> شهر
                    </label>
                    <select id="filterCity" class="form-control">
                        <option value="">همه شهرها</option>
                        <option value="کابل">کابل</option>
                        <option value="هرات">هرات</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6 form-group mb-3 mb-md-0">
                    <label class="flabel" for="filterRoom">
                        <i class="la la-home text-primary"></i> نمبر اتاق
                    </label>
                    <input type="text" id="filterRoom" class="form-control" placeholder="مثلاً A-12">
                </div>
                <div class="col-lg-3 col-md-12">
                    <button type="button" class="btn btn-primary btn-block" id="btnFilter" style="background: #1a56db; border: none; border-radius: 8px; height: 42px; font-weight: 600;">
                        <i class="la la-filter"></i> اعمال فیلتر هوشمند
                    </button>
                </div>
            </div>
        </div>

        {{-- جدول نمایش داده‌ها درون کارد لوکس و یکپارچه --}}
        <div class="card custom-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="contractsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>کد قرارداد</th>
                            <th>نام کامل</th>
                            <th>نمبر اتاق</th>
                            <th>تاریخ قرارداد</th>
                                <th>مبلغ پرداختی</th>
                                <th>مبلغ پرداخت شده</th>
                            <th>وضعیت</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody id="contractsBody">
                        @forelse($contracts as $index => $contract)
                            <tr data-code="{{ $contract->id }}" data-name="{{ $contract->resident->name ?? '' }}" data-room="{{ $contract->resident->room->room_number ?? '' }}" data-status="{{ $contract->contract_status ?? '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $contract->id }}</td>
                                <td>{{ $contract->resident->name ?? '—' }}</td>
                                <td>{{ $contract->resident->room->room_number ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($contract->contract_date)->format('Y-m-d') }}</td>
                                <td>{{ number_format($contract->contract_amount, 0, '.', ',') }} افغانی</td>
                                <td>{{ number_format($paymentTotals[$contract->resident_id] ?? 0, 0, '.', ',') }} افغانی</td>
                                <td><span class="badge {{ $contract->contract_status == 'فعال' ? 'badge-custom-green' : ($contract->contract_status == 'غيرفعال' ? 'badge-custom-red' : 'badge-custom-orange') }}">{{ $contract->contract_status }}</span></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-outline-primary btn-sm" title="ویرایش"><i class="la la-edit"></i></a>
                                        <a href="{{ route('contracts.show', $contract->id) }}" class="btn btn-outline-info btn-sm" title="نمایش"><i class="la la-eye"></i></a>
                                        <button type="button" class="btn btn-outline-success btn-sm btn-payment-open" title="پرداخت"
                                            data-resident-id="{{ $contract->resident_id }}"
                                            data-resident-name="{{ $contract->resident->name ?? '' }}"
                                            data-contract-amount="{{ (float) $contract->contract_amount }}"
                                            data-paid-amount="{{ (float) ($paymentTotals[$contract->resident_id] ?? 0) }}">
                                            <i class="la la-credit-card"></i>
                                        </button>
                                        <form method="post" action="{{ route('contracts.toggle', $contract->id) }}" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-secondary btn-sm" title="غیرفعال/فعال">
                                                <i class="la la-toggle-off"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyFilterRow">
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="la la-inbox font-large-2 d-block mb-1 text-primary"></i> هیچ قراردادی یافت نشد
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-light d-flex align-items-center justify-content-between flex-wrap py-3" style="border-top: 1px solid #e2e8f0;">
                <span class="text-muted font-small-3" id="tableInfo">نمایش ۳ قرارداد</span>
                <span class="text-muted font-small-3">
                    <i class="la la-info-circle text-primary"></i> برای مدیریت سریع‌تر از فیلترهای بالا استفاده کنید.
                </span>
            </div>
        </div>

        <div id="paymentModalOverlay" class="payment-modal-overlay" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,.45); z-index:1040; backdrop-filter:blur(2px);"></div>
        <div id="paymentModal" class="payment-modal" role="dialog" aria-modal="true" aria-labelledby="paymentModalTitle" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); width:min(92vw, 560px); max-height:90vh; overflow:auto; background:#fff; border-radius:16px; box-shadow:0 20px 60px rgba(15,23,42,.25); padding:24px; z-index:1055;">
            <form id="paymentForm" method="post" action="{{ route('contracts.payment.store') }}" novalidate>
                @csrf
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <h5 id="paymentModalTitle">پرداخت قرارداد</h5>
                        <div class="text-muted" style="font-size: 13px;">در اینجا مقدار پرداخت شده برای قرارداد را وارد و ذخیره کنید.</div>
                    </div>
                    <button type="button" id="paymentModalClose" class="btn btn-sm btn-link text-dark" style="font-size: 22px; line-height: 1;">×</button>
                </div>
                <input type="hidden" id="contractIdInput" name="resident_id">
                <div class="mb-3" style="border-radius: 12px; background: #f8fafc; padding: 14px;">
                    <div class="font-weight-bold mb-1" id="paymentContractName">اقامت‌کننده انتخاب‌شده</div>
                    <div class="text-muted" style="font-size: 13px;">آیدی اقامت‌کننده: <span id="paymentContractCode">—</span></div>
                </div>
                <div class="mb-3" style="border-radius: 12px; background: #eef8f2; padding: 14px; border: 1px solid #c8ebd6;">
                    <div class="font-weight-bold mb-1" style="color: #047857;">اطلاعات پرداخت</div>
                    <div class="text-muted" style="font-size: 13px; margin-bottom: 4px;">مبلغ قرارداد: <span id="paymentContractAmount" style="font-weight: 700; color: #1f2937;">۰</span> افغانی</div>
                    <div class="text-muted" style="font-size: 13px; margin-bottom: 4px;">پرداخت شده این ماه: <span id="paymentResidentPaidTotal" style="font-weight: 700; color: #047857;">۰</span> افغانی</div>
                    <div class="text-muted" style="font-size: 13px;">مانده: <span id="paymentRemainingAmount" style="font-weight: 700; color: #dc2626;">۰</span> افغانی</div>
                </div>
                <div class="form-group mb-3">
                    <label class="flabel" for="paymentAmountInput">مبلغ جدید پرداختی (افغانی)</label>
                    <input type="number" id="paymentAmountInput" name="amount" class="form-control" placeholder="مثلاً 2500" min="1" step="100" required>
                </div>
                <div class="form-group mb-3">
                    <label class="flabel" for="paymentDateInput">تاریخ پرداخت</label>
                    <input type="text" id="paymentDateInput" name="payment_date" class="form-control" placeholder="انتخاب تاریخ" data-jdp required>
                </div>
                <div class="form-group mb-3">
                    <label class="flabel" for="notes">توضیحات</label>
                    <input type="text" id="notes" name="notes" class="form-control" placeholder="توضیحات اختیاری">
                </div>
                <div class="d-flex justify-content-end align-items-center flex-wrap" style="gap: 10px;">
                    <button type="button" id="paymentModalCancel" class="btn btn-secondary">انصراف</button>
                    <button type="submit" class="btn btn-primary btn-payment-save">ثبت پرداخت</button>
                </div>
            </form>
        </div>

    </div>
</div>

<style>
    .jdp-container {
        z-index: 1100 !important;
    }
</style>

<script>
    jalaliDatepicker.startWatch({
        zIndex: 1100,
        persianDigits: true,
        showDays: false,
        targetValueType: 'gregorian',
        targetValueInput: '#paymentDateInput',
        months: ['حمل', 'ثور', 'جوزا', 'سرطان', 'اسد', 'سنبله', 'میزان', 'عقرب', 'قوس', 'جدی', 'دلو', 'حوت']
    });
    document.addEventListener('DOMContentLoaded', function () {
        const paymentModalOverlay = document.getElementById('paymentModalOverlay');
        const paymentModal = document.getElementById('paymentModal');
        const paymentForm = document.getElementById('paymentForm');
        const paymentContractName = document.getElementById('paymentContractName');
        const paymentContractCode = document.getElementById('paymentContractCode');
        const paymentContractAmount = document.getElementById('paymentContractAmount');
        const paymentResidentPaidTotal = document.getElementById('paymentResidentPaidTotal');
        const paymentRemainingAmount = document.getElementById('paymentRemainingAmount');
        const contractIdInput = document.getElementById('contractIdInput');
        const paymentModalClose = document.getElementById('paymentModalClose');
        const paymentModalCancel = document.getElementById('paymentModalCancel');

        function openPaymentModal(residentId, residentName, contractAmount, paidAmount) {
            if (!paymentModal || !paymentModalOverlay) return;
            const parsedContractAmount = parseFloat(contractAmount) || 0;
            const parsedPaidAmount = parseFloat(paidAmount) || 0;

            paymentContractName.textContent = residentName || 'اقامت‌کننده انتخاب‌شده';
            paymentContractCode.textContent = residentId || '—';
            contractIdInput.value = residentId || '';
            paymentContractAmount.textContent = parsedContractAmount.toLocaleString('fa-IR');
            paymentResidentPaidTotal.textContent = parsedPaidAmount.toLocaleString('fa-IR');
            const remaining = parsedContractAmount - parsedPaidAmount;
            paymentRemainingAmount.textContent = remaining.toLocaleString('fa-IR');
            paymentModal.style.display = 'block';
            paymentModalOverlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closePaymentModal() {
            if (!paymentModal || !paymentModalOverlay) return;
            paymentModal.style.display = 'none';
            paymentModalOverlay.style.display = 'none';
            document.body.style.overflow = '';
        }

        document.querySelectorAll('.btn-payment-open').forEach(function (button) {
            button.addEventListener('click', function () {
                const residentId = this.getAttribute('data-resident-id') || this.dataset.residentId;
                const residentName = this.getAttribute('data-resident-name') || this.dataset.residentName;
                const contractAmount = this.getAttribute('data-contract-amount') || this.dataset.contractAmount;
                const paidAmount = this.getAttribute('data-paid-amount') || this.dataset.paidAmount;
                openPaymentModal(residentId, residentName, contractAmount, paidAmount);
            });
        });

        if (paymentModalClose) paymentModalClose.addEventListener('click', closePaymentModal);
        if (paymentModalCancel) paymentModalCancel.addEventListener('click', closePaymentModal);
        if (paymentModalOverlay) paymentModalOverlay.addEventListener('click', closePaymentModal);
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') closePaymentModal();
        });
    });
</script>

@endsection
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

        {{-- استایل‌های اختصاصی پالت رنگی سازمانی آبی --}}
        <style>
            .custom-card {
                background: #ffffff;
                border: 1px solid #e2e8f0 !important;
                border-radius: 12px !important;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                margin-bottom: 25px;
                overflow: hidden;
            }
            .filter-box {
                background: #f8fafc !important; /* پس‌زمینه بسیار لایت جایگزین خاکستری تند */
                border: 1px solid #e2e8f0 !important;
                border-radius: 12px;
                padding: 20px;
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
            .table thead th {
                background-color: #1a56db !important;
                color: #ffffff !important;
                font-weight: 600;
                font-size: 13px;
                border: none !important;
                padding: 14px 10px;
            }
            .table tbody td {
                padding: 12px 10px;
                vertical-align: middle;
                font-size: 13px;
                color: #334155;
                border-bottom: 1px solid #f1f5f9 !important;
            }
            .table-responsive {
                max-height: calc(100vh - 260px);
                overflow-x: auto;
                overflow-y: auto;
                min-height: 200px;
                direction: rtl;
            }
            .table-responsive table {
                margin-bottom: 0;
                min-width: 1200px;
            }
            .badge-custom-blue { background: rgba(26, 86, 219, 0.1); color: #1a56db; font-weight: 600; border-radius: 6px; padding: 5px 10px; }
            .badge-custom-green { background: rgba(4, 120, 87, 0.1); color: #047857; font-weight: 600; border-radius: 6px; padding: 5px 10px; }
            .badge-custom-orange { background: rgba(217, 119, 6, 0.1); color: #d97706; font-weight: 600; border-radius: 6px; padding: 5px 10px; }
            .badge-custom-red { background: rgba(220, 38, 38, 0.1); color: #dc2424; font-weight: 600; border-radius: 6px; padding: 5px 10px; }
            .payment-modal-overlay {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.45);
                z-index: 1050;
                display: none;
            }
            .payment-modal {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: min(100%, 540px);
                max-height: 92vh;
                overflow-y: auto;
                background: #ffffff;
                border-radius: 16px;
                padding: 22px;
                box-shadow: 0 25px 50px rgba(15, 23, 42, 0.18);
                z-index: 1055;
                display: none;
            }
            .payment-modal h5 {
                margin: 0;
                font-size: 18px;
                font-weight: 700;
            }
            .payment-modal .payment-row {
                border-bottom: 1px solid #e2e8f0;
                padding: 11px 0;
            }
            .payment-modal .payment-row:last-child {
                border-bottom: none;
            }
            .payment-modal .payment-summary-item {
                font-size: 14px;
                color: #334155;
            }
            .payment-modal .btn-payment-save {
                background: #1a56db;
                border: none;
            }
        </style>

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
                            <th>کد</th>
                            <th>نام کامل</th>
                            <th>نام پدر</th>
                            <th>شهر</th>
                            <th>نمبر اتاق</th>
                            <th>شغل</th>
                            <th>شماره تلیفون</th>
                            <th>موقعیت شغل</th>
                            <th>تاریخ قرارداد</th>
                            <th>مدت</th>
                            <th>وضعیت</th>
                            <th>مبلغ پرداختی</th>
                            <th>ماه پرداخت</th>
                            <th>وضعیت پرداخت</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody id="contractsBody">
                        {{-- ردیف نمونه ۱ --}}
                        <tr data-code="1001" data-name="احمد نوری" data-father="محمد نوری" data-city="کابل" data-room="A-12" data-occupation="محصل" data-phone="0700123456" data-location="پوهنتون کابل" data-date="1404/02/15" data-duration="۱ سال" data-status="فعال" data-payment-amount="3500" data-months-paid="2" data-payment-status="پرداخت شده">
                            <td>۱</td>
                            <td><span class="badge-custom-blue">1001</span></td>
                            <td class="font-weight-bold">احمد نوری</td>
                            <td>محمد نوری</td>
                            <td>کابل</td>
                            <td><span class="badge-custom-blue">A-12</span></td>
                            <td>محصل</td>
                            <td dir="ltr" class="text-right">0700123456</td>
                            <td>پوهنتون کابل</td>
                            <td>1404/02/15</td>
                            <td>۱ سال</td>
                            <td><span class="badge-custom-green">فعال</span></td>
                            <td>۳,۵۰۰ افغانی</td>
                            <td>۲ ماه</td>
                            <td><span class="badge-custom-green">پرداخت شده</span></td>
                            <td class="text-center text-nowrap">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-demo-view" style="border-radius: 6px 0 0 6px;" title="مشاهده"><i class="la la-eye"></i></button>
                                    <button type="button" class="btn btn-outline-info" title="ویرایش"><i class="la la-edit"></i></button>
                                    <button type="button" class="btn btn-outline-danger btn-delete" style="border-radius: 0 6px 6px 0;" title="حذف"><i class="la la-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        {{-- ردیف نمونه ۲ --}}
                        <tr data-code="1002" data-name="علی رحیمی" data-father="عبدالرحیم" data-city="هرات" data-room="B-07" data-occupation="کارمند" data-phone="0700554433" data-location="شرکت خصوصی" data-date="1404/01/20" data-duration="۶ ماه" data-status="فعال" data-payment-amount="3500" data-months-paid="1" data-payment-status="پرداخت شده">
                            <td>۲</td>
                            <td><span class="badge-custom-blue">1002</span></td>
                            <td class="font-weight-bold">علی رحیمی</td>
                            <td>عبدالرحیم</td>
                            <td>هرات</td>
                            <td><span class="badge-custom-blue">B-07</span></td>
                            <td>کارمند</td>
                            <td dir="ltr" class="text-right">0700554433</td>
                            <td>شرکت خصوصی</td>
                            <td>1404/01/20</td>
                            <td>۶ ماه</td>
                            <td><span class="badge-custom-green">فعال</span></td>
                            <td>۳,۵۰۰ افغانی</td>
                            <td>۱ ماه</td>
                            <td><span class="badge-custom-green">پرداخت شده</span></td>
                            <td class="text-center text-nowrap">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-demo-view" style="border-radius: 6px 0 0 6px;" title="مشاهده"><i class="la la-eye"></i></button>
                                    <button type="button" class="btn btn-outline-info" title="ویرایش"><i class="la la-edit"></i></button>
                                    <button type="button" class="btn btn-outline-danger btn-delete" style="border-radius: 0 6px 6px 0;" title="حذف"><i class="la la-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        {{-- ردیف نمونه ۳ --}}
                        <tr data-code="1003" data-name="حسین احمدی" data-father="کریم احمدی" data-city="کابل" data-room="C-03" data-occupation="دانشجو" data-phone="0788991122" data-location="پوهنتون پلی‌تکنیک" data-date="1404/03/01" data-duration="۲ سال" data-status="در انتظار" data-payment-amount="0" data-months-paid="0" data-payment-status="معوق">
                            <td>۳</td>
                            <td><span class="badge-custom-blue">1003</span></td>
                            <td class="font-weight-bold">حسین احمدی</td>
                            <td>کریم احمدی</td>
                            <td>کابل</td>
                            <td><span class="badge-custom-blue">C-03</span></td>
                            <td>دانشجو</td>
                            <td dir="ltr" class="text-right">0788991122</td>
                            <td>پوهنتون پلی‌تکنیک</td>
                            <td>1404/03/01</td>
                            <td>۲ سال</td>
                            <td><span class="badge-custom-orange">در انتظار</span></td>
                            <td>—</td>
                            <td>۰ ماه</td>
                            <td><span class="badge-custom-red">معوق</span></td>
                            <td class="text-center text-nowrap">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-demo-view" style="border-radius: 6px 0 0 6px;" title="مشاهده"><i class="la la-eye"></i></button>
                                    <button type="button" class="btn btn-outline-info" title="ویرایش"><i class="la la-edit"></i></button>
                                    <button type="button" class="btn btn-outline-danger btn-delete" style="border-radius: 0 6px 6px 0;" title="حذف"><i class="la la-trash"></i></button>
                                </div>
                            </td>
                        </tr>
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

        <div id="paymentModalOverlay" class="payment-modal-overlay"></div>
        <div id="paymentModal" class="payment-modal" role="dialog" aria-modal="true" aria-labelledby="paymentModalTitle">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <h5 id="paymentModalTitle">پرداخت قرارداد</h5>
                    <div class="text-muted" style="font-size: 13px;">در اینجا مقدار پرداخت شده برای قرارداد را وارد و ذخیره کنید.</div>
                </div>
                <button type="button" id="paymentModalClose" class="btn btn-sm btn-link text-dark" style="font-size: 22px; line-height: 1;">×</button>
            </div>
            <div class="mb-3" style="border-radius: 12px; background: #f8fafc; padding: 14px;">
                <div class="font-weight-bold mb-1" id="paymentContractName">قرارداد انتخاب‌شده</div>
                <div class="text-muted" style="font-size: 13px;">کد قرارداد: <span id="paymentContractCode">—</span></div>
            </div>
            <div class="form-group mb-3">
                <label class="flabel" for="paymentAmountInput">مبلغ جدید پرداختی (افغانی)</label>
                <input type="number" id="paymentAmountInput" class="form-control" placeholder="مثلاً 2500" min="1" step="100">
            </div>
            <div class="d-flex justify-content-between flex-wrap mb-3" style="gap: 10px;">
                <div class="payment-summary-item"><strong>کل پرداختی تاکنون:</strong> <span id="paymentInfoTotal">0 افغانی</span></div>
                <div class="payment-summary-item"><strong>ماه‌های ثبت شده:</strong> <span id="paymentInfoMonths">0</span></div>
                <div class="payment-summary-item"><strong>وضعیت پرداخت:</strong> <span id="paymentInfoStatus">پرداخت نشده</span></div>
            </div>
            <div class="mb-4">
                <h6 class="font-weight-bold mb-2">سوابق پرداخت‌های ثبت‌شده</h6>
                <div id="paymentListContainer" class="px-3 py-3" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; min-height: 120px;">
                    <div class="text-muted" style="font-size: 14px;">هیچ پرداختی ثبت نشده است.</div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 10px;">
                <button type="button" id="paymentModalCancel" class="btn btn-secondary">انصراف</button>
                <button type="button" id="paymentSaveButton" class="btn btn-primary btn-payment-save">ثبت پرداخت</button>
            </div>
        </div>

    </div>
</div>

<script>
(function () {
    const rows = Array.from(document.querySelectorAll('#contractsBody tr[data-code]'));
    const totalRows = rows.length;

    const filterSearch = document.getElementById('filterSearch');
    const filterStatus = document.getElementById('filterStatus');
    const filterCity = document.getElementById('filterCity');
    const filterRoom = document.getElementById('filterRoom');
    const tableInfo = document.getElementById('tableInfo');
    const paymentModalOverlay = document.getElementById('paymentModalOverlay');
    const paymentModal = document.getElementById('paymentModal');
    const paymentContractName = document.getElementById('paymentContractName');
    const paymentContractCode = document.getElementById('paymentContractCode');
    const paymentAmountInput = document.getElementById('paymentAmountInput');
    const paymentInfoTotal = document.getElementById('paymentInfoTotal');
    const paymentInfoMonths = document.getElementById('paymentInfoMonths');
    const paymentInfoStatus = document.getElementById('paymentInfoStatus');
    const paymentListContainer = document.getElementById('paymentListContainer');
    const paymentSaveButton = document.getElementById('paymentSaveButton');
    const paymentModalClose = document.getElementById('paymentModalClose');
    const paymentModalCancel = document.getElementById('paymentModalCancel');
    let currentPaymentCode = null;
    const paymentData = {};

    function applyFilter() {
        const q = (filterSearch.value || '').trim().toLowerCase();
        const status = filterStatus.value;
        const city = filterCity.value;
        const room = (filterRoom.value || '').trim().toLowerCase();
        let visible = 0;

        rows.forEach(function (row) {
            const matchSearch = !q || [
                row.dataset.code,
                row.dataset.name,
                row.dataset.father,
                row.dataset.room,
                row.dataset.phone,
                row.dataset.occupation,
                row.dataset.location
            ].some(function (v) { return (v || '').toLowerCase().indexOf(q) !== -1; });

            const matchStatus = !status || row.dataset.status === status;
            const matchCity = !city || row.dataset.city === city;
            const matchRoom = !room || (row.dataset.room || '').toLowerCase().indexOf(room) !== -1;

            const show = matchSearch && matchStatus && matchCity && matchRoom;
            row.style.display = show ? '' : 'none';
            if (show) {
                visible++;
                row.cells[0].textContent = visible;
            }
        });

        tableInfo.textContent = 'نمایش ' + visible.toLocaleString('fa-IR') + ' قرارداد از ' + totalRows.toLocaleString('fa-IR');

        let emptyRow = document.getElementById('emptyFilterRow');
        if (visible === 0) {
            if (!emptyRow) {
                emptyRow = document.createElement('tr');
                emptyRow.id = 'emptyFilterRow';
                emptyRow.innerHTML = '<td colspan="16" class="text-center text-muted py-4">' +
                    '<i class="la la-inbox font-large-2 d-block mb-1 text-primary"></i>قراردادی با این فیلتر یافت نشد</td>';
                document.getElementById('contractsBody').appendChild(emptyRow);
            }
            emptyRow.style.display = '';
        } else if (emptyRow) {
            emptyRow.style.display = 'none';
        }
    }

    document.getElementById('btnFilter').addEventListener('click', applyFilter);
    filterSearch.addEventListener('keyup', function (e) {
        if (e.key === 'Enter') applyFilter();
    });
    [filterStatus, filterCity].forEach(function (el) {
        el.addEventListener('change', applyFilter);
    });
    filterRoom.addEventListener('keyup', function (e) {
        if (e.key === 'Enter') applyFilter();
    });

    document.querySelectorAll('.btn-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (confirm('آیا از حذف این قرارداد مطمئن هستید؟')) {
                alert('حذف قرارداد — پس از اتصال به سرور فعال می‌شود.');
            }
        });
    });

    function formatAmount(value) {
        return Number(value || 0).toLocaleString('fa-IR') + ' افغانی';
    }

    function formatCount(value) {
        return Number(value || 0).toLocaleString('fa-IR');
    }

    function getBadgeClass(status) {
        if (status === 'معوق') return 'badge-custom-red';
        if (status === 'پرداخت نشده') return 'badge-custom-orange';
        return 'badge-custom-green';
    }

    function updateRowPaymentCells(row, data) {
        if (!row) return;
        row.dataset.paymentAmount = data.total;
        row.dataset.monthsPaid = data.monthsPaid;
        row.dataset.paymentStatus = data.status;

        const paymentCell = row.cells[12];
        const monthsCell = row.cells[13];
        const statusCell = row.cells[14];

        if (paymentCell) paymentCell.textContent = data.total > 0 ? formatAmount(data.total) : '—';
        if (monthsCell) monthsCell.textContent = formatCount(data.monthsPaid) + ' ماه';
        if (statusCell) {
            statusCell.innerHTML = '<span class="' + getBadgeClass(data.status) + '">' + data.status + '</span>';
        }
    }

    function renderPaymentList(code) {
        const data = paymentData[code];
        if (!data) return;

        paymentContractName.textContent = data.name || 'قرارداد انتخاب‌شده';
        paymentContractCode.textContent = code;
        paymentInfoTotal.textContent = formatAmount(data.total);
        paymentInfoMonths.textContent = formatCount(data.monthsPaid);
        paymentInfoStatus.textContent = data.status;

        if (!paymentListContainer) return;

        if (data.payments.length === 0) {
            paymentListContainer.innerHTML = '<div class="text-muted" style="font-size: 14px;">هیچ پرداختی ثبت نشده است.</div>';
            return;
        }

        paymentListContainer.innerHTML = data.payments.map(function (row) {
            return '<div class="payment-row d-flex justify-content-between align-items-center">' +
                '<div><strong>' + formatAmount(row.amount) + '</strong><div class="text-muted" style="font-size: 13px;">' + row.date + '</div></div>' +
                '</div>';
        }).join('');
    }

    function openPaymentModal(row) {
        if (!row) return;
        currentPaymentCode = row.dataset.code;
        const code = currentPaymentCode;
        const data = paymentData[code];

        if (!data) return;
        data.name = row.dataset.name || 'قرارداد';

        if (paymentAmountInput) paymentAmountInput.value = '';
        if (paymentModal) paymentModal.style.display = 'block';
        if (paymentModalOverlay) paymentModalOverlay.style.display = 'block';
        document.body.style.overflow = 'hidden';

        renderPaymentList(code);
    }

    function closePaymentModal() {
        currentPaymentCode = null;
        if (paymentModal) paymentModal.style.display = 'none';
        if (paymentModalOverlay) paymentModalOverlay.style.display = 'none';
        document.body.style.overflow = '';
    }

    function createPaymentButton(row) {
        const group = row.querySelector('.btn-group');
        if (!group || row.querySelector('.btn-pay')) return;

        const payButton = document.createElement('button');
        payButton.type = 'button';
        payButton.className = 'btn btn-outline-success btn-pay';
        payButton.style.borderRadius = '0';
        payButton.title = 'ثبت پرداخت';
        payButton.innerHTML = '<i class="la la-credit-card"></i>';
        payButton.addEventListener('click', function () {
            openPaymentModal(row);
        });
        group.appendChild(payButton);
    }

    function addPaymentRecord() {
        if (!currentPaymentCode) return;
        const amount = Number(paymentAmountInput.value || 0);
        if (!amount || amount <= 0) {
            alert('لطفاً مبلغ پرداختی را وارد کنید.');
            return;
        }

        const now = new Date();
        const paymentDate = now.toLocaleDateString('fa-IR');
        const data = paymentData[currentPaymentCode];
        data.payments.push({ amount: amount, date: paymentDate });
        data.total += amount;
        data.monthsPaid += 1;
        data.status = data.total > 0 ? 'پرداخت شده' : 'پرداخت نشده';

        const row = document.querySelector('#contractsBody tr[data-code="' + currentPaymentCode + '"]');
        updateRowPaymentCells(row, data);
        renderPaymentList(currentPaymentCode);
        if (paymentAmountInput) paymentAmountInput.value = '';
    }

    rows.forEach(function (row) {
        const code = row.dataset.code;
        paymentData[code] = {
            payments: [],
            total: Number(row.dataset.paymentAmount || 0),
            monthsPaid: Number(row.dataset.monthsPaid || 0),
            status: row.dataset.paymentStatus || 'پرداخت نشده',
            name: row.dataset.name || ''
        };
        updateRowPaymentCells(row, paymentData[code]);
        createPaymentButton(row);
    });

    if (paymentModalClose) paymentModalClose.addEventListener('click', closePaymentModal);
    if (paymentModalCancel) paymentModalCancel.addEventListener('click', closePaymentModal);
    if (paymentModalOverlay) paymentModalOverlay.addEventListener('click', closePaymentModal);
    if (paymentSaveButton) paymentSaveButton.addEventListener('click', addPaymentRecord);
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closePaymentModal();
    });
})();
</script>

@endsection
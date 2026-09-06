<div class="payment-demo" dir="rtl">
    <style>
        .payment-demo .panel, .payment-demo .stat-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; box-shadow:0 4px 10px rgba(15,23,42,.04); }
        .payment-demo .panel-header { background:#f8fafc; border-bottom:1px solid #e2e8f0; color:#1e293b; font-weight:700; padding:15px 20px; }
        .payment-demo .panel-body { padding:20px; }
        .payment-demo .stat-card { height:100%; padding:20px; }
        .payment-demo .stat-label { color:#64748b; font-size:12px; }
        .payment-demo .stat-value { color:#1e293b; display:block; font-size:24px; font-weight:800; margin-top:7px; }
        .payment-demo .stat-value.paid { color:#059669; } .payment-demo .stat-value.balance { color:#dc2626; }
        .payment-demo .table thead th { background:#059669; border:0; color:#fff; font-size:12px; white-space:nowrap; }
        .payment-demo .table td { color:#334155; font-size:13px; vertical-align:middle; }
        .payment-demo .status { border-radius:6px; display:inline-block; font-size:11px; font-weight:700; padding:5px 9px; white-space:nowrap; }
        .payment-demo .status.complete { background:#d1fae5; color:#047857; } .payment-demo .status.partial { background:#fef3c7; color:#b45309; } .payment-demo .status.unpaid { background:#fee2e2; color:#b91c1c; }
        .payment-demo .demo-note { color:#64748b; font-size:12px; }
        .payment-demo .resident-result { align-items:center; background:#fff; border:1px solid #e2e8f0; border-radius:8px; cursor:pointer; display:flex; justify-content:space-between; margin-top:6px; padding:10px 12px; width:100%; }
        .payment-demo .resident-result:hover { border-color:#059669; background:#f0fdf4; }
    </style>

    <div class="panel mb-4">
        <div class="panel-header"><i class="la la-search ml-2" style="color:#059669"></i>جستجوی ساکن</div>
        <div class="panel-body">
            <input type="search" wire:model.live.debounce.350ms="search" class="form-control" placeholder="نام، کد ساکن یا شماره اتاق را وارد کنید">
            @if ($search !== '')
                <div class="mt-2">
                    @forelse ($residents as $resident)
                        <button type="button" class="resident-result" wire:click="selectResident({{ $resident->id }})">
                            <span><strong>{{ $resident->name }}</strong> · {{ $resident->resident_code }}</span>
                            <span class="demo-note">اتاق {{ $resident->room?->room_number ?? '-' }}</span>
                        </button>
                    @empty
                        <div class="alert alert-info mt-2 mb-0">ساکنی با این مشخصات پیدا نشد.</div>
                    @endforelse
                </div>
            @endif
        </div>
    </div>

    @if ($selectedResident)
        <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
            <div>
                <h5 class="mb-1">وضعیت مالی {{ $selectedResident['name'] }}</h5>
                <span class="demo-note">کد {{ $selectedResident['code'] }} · اتاق {{ $selectedResident['room'] }}</span>
            </div>
            <button type="button" wire:click="clearSelection" class="btn btn-outline-secondary btn-sm mt-2 mt-sm-0"><i class="la la-refresh"></i> انتخاب ساکن دیگر</button>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-3"><div class="stat-card"><span class="stat-label">مجموع صورتحساب‌ها</span><span class="stat-value">{{ number_format($summary['total']) }} افغانی</span></div></div>
            <div class="col-md-4 mb-3"><div class="stat-card"><span class="stat-label">مجموع پرداخت‌ها</span><span class="stat-value paid">{{ number_format($summary['paid']) }} افغانی</span></div></div>
            <div class="col-md-4 mb-3"><div class="stat-card"><span class="stat-label">بدهی فعلی</span><span class="stat-value balance">{{ number_format($summary['balance']) }} افغانی</span></div></div>
        </div>

        <div class="panel">
            <div class="panel-header"><i class="la la-list-alt ml-2" style="color:#059669"></i>تاریخچه صورتحساب و پرداخت</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>#</th><th>دوره</th><th>شماره فاکتور</th><th>مبلغ صورتحساب</th><th>پرداختی</th><th>مانده</th><th>تاریخ پرداخت</th><th>وضعیت</th></tr></thead>
                    <tbody>
                        @forelse ($invoices as $index => $invoice)
                            <tr>
                                <td>{{ $index + 1 }}</td><td><strong>{{ $invoice['period'] }}</strong></td><td>{{ $invoice['invoice'] }}</td>
                                <td>{{ number_format($invoice['total']) }} افغانی</td><td style="color:#059669; font-weight:700">{{ number_format($invoice['paid']) }} افغانی</td>
                                <td style="color:{{ $invoice['balance'] ? '#dc2626' : '#047857' }}; font-weight:700">{{ number_format($invoice['balance']) }} افغانی</td>
                                <td>{{ $invoice['paid_at'] ?? '—' }}</td>
                                <td><span class="status {{ $invoice['balance'] === 0 ? 'complete' : ($invoice['paid'] ? 'partial' : 'unpaid') }}">{{ $invoice['status'] }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center demo-note">برای این ساکن قراردادی ثبت نشده است.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="panel text-center p-5">
            <i class="la la-search" style="font-size:32px; color:#94a3b8"></i>
            <p class="demo-note mb-0 mt-2">برای نمایش گزارش، ابتدا یک ساکن را جستجو و انتخاب کنید.</p>
        </div>
    @endif
</div>

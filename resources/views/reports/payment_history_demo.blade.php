@extends('layouts.generalLayouts')

@section('content')
    @livewire('payment-history')
    @if (false)
    <style>
        .payment-demo .top-banner {
            background: linear-gradient(135deg, #0f766e, #059669);
            border-radius: 12px;
            padding: 22px 20px;
            color: #fff;
            box-shadow: 0 4px 12px rgba(5, 150, 105, .15);
        }

        .payment-demo .panel,
        .payment-demo .stat-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(15, 23, 42, .04);
        }

        .payment-demo .stat-card {
            padding: 20px;
            height: 100%;
        }

        .payment-demo .stat-label {
            color: #64748b;
            font-size: 12px;
        }

        .payment-demo .stat-value {
            color: #1e293b;
            display: block;
            font-size: 24px;
            font-weight: 800;
            margin-top: 7px;
        }

        .payment-demo .stat-value.paid { color: #059669; }
        .payment-demo .stat-value.balance { color: #dc2626; }
        .payment-demo .panel-header {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
            font-weight: 700;
            padding: 15px 20px;
        }

        .payment-demo .panel-body { padding: 20px; }
        .payment-demo .table thead th {
            background: #059669;
            border: 0;
            color: #fff;
            font-size: 12px;
            white-space: nowrap;
        }

        .payment-demo .table td {
            color: #334155;
            font-size: 13px;
            vertical-align: middle;
        }

        .payment-demo .status {
            border-radius: 6px;
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            padding: 5px 9px;
            white-space: nowrap;
        }

        .payment-demo .status.complete { background: #d1fae5; color: #047857; }
        .payment-demo .status.partial { background: #fef3c7; color: #b45309; }
        .payment-demo .status.unpaid { background: #fee2e2; color: #b91c1c; }
        .payment-demo .demo-note { color: #64748b; font-size: 12px; }
    </style>

    <div class="payment-demo" dir="rtl">
        <div class="top-banner mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <div>
                    <h5 class="text-white mb-1 font-weight-bold">گزارش تاریخی پرداخت ساکنین</h5>
                    <p class="mb-0" style="color:rgba(255,255,255,.82); font-size:13px;">
                        نمایشی از صورتحساب‌ها، پرداخت‌ها و بدهی واقعی تا تاریخ گزارش
                    </p>
                </div>
                <span class="badge badge-pill mt-2 mt-sm-0" style="background:rgba(255,255,255,.2); color:#fff; padding:8px 14px;">
                    <i class="la la-database"></i> اطلاعات ثبت‌شده
                </span>
            </div>
        </div>

        <div class="panel mb-4">
            <div class="panel-header"><i class="la la-user ml-2" style="color:#059669"></i>انتخاب ساکن</div>
            <div class="panel-body">
                <form method="GET" action="{{ route('report.payments_history') }}" class="form-row align-items-end">
                    <div class="col-md-5 mb-2">
                        <label class="demo-note mb-1">ساکن مورد نظر</label>
                        <select name="resident" class="form-control">
                            @foreach($residents as $resident)
                                <option value="{{ $resident['id'] }}" @selected($resident['id'] === $selectedResident['id'])>
                                    {{ $resident['name'] }} · {{ $resident['code'] }} · اتاق {{ $resident['room'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-success btn-block" type="submit"><i class="la la-search"></i> نمایش گزارش</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
            <div>
                <h5 class="mb-1">وضعیت مالی {{ $selectedResident['name'] }}</h5>
                <span class="demo-note">کد {{ $selectedResident['code'] }} · اتاق {{ $selectedResident['room'] }}</span>
            </div>
            <span class="demo-note mt-2 mt-sm-0">تمام صورتحساب‌های سررسیدشده در محاسبه لحاظ شده‌اند</span>
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
                        @foreach($selectedResident['invoices'] as $index => $invoice)
                            <tr>
                                <td>{{ $index + 1 }}</td><td><strong>{{ $invoice['period'] }}</strong></td><td>{{ $invoice['invoice'] }}</td>
                                <td>{{ number_format($invoice['total']) }} افغانی</td><td style="color:#059669; font-weight:700">{{ number_format($invoice['paid']) }} افغانی</td>
                                <td style="color:{{ $invoice['balance'] ? '#dc2626' : '#047857' }}; font-weight:700">{{ number_format($invoice['balance']) }} افغانی</td>
                                <td>{{ $invoice['paid_at'] ?? '—' }}</td>
                                <td><span class="status {{ $invoice['balance'] === 0 ? 'complete' : ($invoice['paid'] ? 'partial' : 'unpaid') }}">{{ $invoice['status'] }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-body border-top demo-note">
                        مبلغ پرداختی از پرداخت‌های ثبت‌شده برای این ساکن و به‌ترتیب تاریخ روی قراردادها محاسبه شده است.
            </div>
        </div>
    </div>
    @endif
@endsection
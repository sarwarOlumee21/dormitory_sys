@extends('layouts.generalLayouts')

@section('content')
    <div class="row g-3" dir="rtl">
        <!-- بخش هدر کنترل (در هنگام پرینت مخفی می‌شود) -->
        <div class="col-12 d-print-none">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-secondary fw-bold">نمایش قرارداد #{{ $contract->id }}</h5>
                    <div class="d-flex gap-2">
                        <style>
                            @media print {

                                body * {
                                    visibility: hidden;
                                }

                                .card.shadow-sm.border-light.p-4.p-md-5.bg-white.m-0.border-0.m-print-0.p-print-0,
                                .card.shadow-sm.border-light.p-4.p-md-5.bg-white.m-0.border-0.m-print-0.p-print-0 * {
                                    visibility: visible;
                                }

                                .card.shadow-sm.border-light.p-4.p-md-5.bg-white.m-0.border-0.m-print-0.p-print-0 {
                                    position: absolute;
                                    left: 0;
                                    top: 0;
                                    width: 100%;
                                }
                            }
                        </style>
                        <button class="btn btn-success d-flex align-items-center gap-1" onclick="window.print()">
                            <i class="bi bi-printer"></i> پرینت قرارداد
                        </button>
                        <a href="{{ route('contracts.list') }}" class="btn btn-outline-secondary">بازگشت</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- برگه اصلی قرارداد -->
        <div class="col-12">
            <div class="card shadow-sm border-light p-4 p-md-5 bg-white m-0 border-0 m-print-0 p-print-0">
                <!-- هدر سند رسمی -->
                <div class="text-center mb-1">
                    <h4 class="fw-bold text-dark border-bottom border-2 border-dark d-inline-block pb-2 px-4">متن قرارداد
                        رسمی اقامت</h4>
                </div>

                <!-- اطلاعات پایه قرارداد (چیدمان شبکه‌ای منظم روی پس‌زمینه سفید) -->
<div class="row g-2 mb-3 text-dark">

    <div class="col-md-4">
        <div class="p-1 border-bottom border-light">
            <span class="text-muted small">کد قرارداد:</span>
            <strong class="fs-6">{{ $contract->id }}</strong>
        </div>
    </div>

    <div class="col-md-4">
        <div class="p-1 border-bottom border-light">
            <span class="text-muted small">کد اقامت کننده:</span>
            <strong class="fs-6">{{ $contract->resident->id ?? '—' }}</strong>
        </div>
    </div>

    <div class="col-md-4">
        <div class="p-1 border-bottom border-light">
            <span class="text-muted small">نام اقامت‌کننده:</span>
            <strong class="fs-6 text-primary">{{ $contract->resident->name ?? '—' }}</strong>
        </div>
    </div>

    <div class="col-md-4">
        <div class="p-1 border-bottom border-light">
            <span class="text-muted small">نمبر اتاق:</span>
            <strong class="fs-6">{{ $contract->resident->room->room_number ?? '—' }}</strong>
        </div>
    </div>

    <div class="col-md-4">
        <div class="p-1 border-bottom border-light">
            <span class="text-muted small">تاریخ قرارداد:</span>
            <strong class="fs-6">
                {{ \Carbon\Carbon::parse($contract->contract_date)->format('Y-m-d') }}
            </strong>
        </div>
    </div>

    <div class="col-md-4">
        <div class="p-1 border-bottom border-light">
            <span class="text-muted small">مبلغ قرارداد:</span>
            <strong class="fs-6 text-success">
                {{ number_format($contract->contract_amount, 0, '.', ',') }}
            </strong>
            <span class="small text-muted">افغانی</span>
        </div>
    </div>

    <div class="col-md-4">
        <div class="p-1 border-bottom border-light">
            <span class="text-muted small">نام ضامن:</span>
            <strong class="fs-6 text-primary">
                {{ $contract->resident->guarantor_name ?? '—' }}
            </strong>
        </div>
    </div>

    <div class="col-md-4">
        <div class="p-1 border-bottom border-light">
            <span class="text-muted small">شغل ضامن:</span>
            <strong class="fs-6">
                {{ $contract->resident->guarantor_occupation ?? '—' }}
            </strong>
        </div>
    </div>

</div>
                <!-- اطلاعات پایه قرارداد (چیدمان شبکه‌ای منظم روی پس‌زمینه سفید) -->

                <!-- ۱. بخش متن قرارداد کامل (حالا در بالا قرار دارد) -->

                <!-- ۲. بخش متن قوانین (حالا در پایین قرار دارد) -->
                <div class="mb-5 border-start border-4 border-warning ps-3 py-1">

                    <h6 class="fw-bold text-dark text-center mb-4">
                        متن قوانین و مقررات
                    </h6>

                    <div class="text-secondary lh-lg small p-2">

                        <p class="mb-4 text-justify">
                            اینجانب <strong>{{ $contract->resident->name ?? '—' }}</strong>،
                            دارنده کد اقامت‌کننده <strong>{{ $contract->resident->id ?? '—' }}</strong>،
                            ساکن اتاق شماره <strong>{{ $contract->resident->room->room_number ?? '—' }}</strong>،
                            با مطالعه کامل مفاد این قرارداد، تمامی شرایط، قوانین و مقررات مندرج در این سند را پذیرفته و
                            متعهد می‌شوم که در طول مدت اقامت، کلیه موارد ذکرشده را رعایت نمایم. همچنین مسئولیت هرگونه تخلف
                            از مفاد این قرارداد را بر عهده داشته و خود را ملزم به اجرای تمامی تعهدات مندرج می‌دانم.
                        </p>

                        <hr class="my-2">

                        {!! nl2br(e($rules->contract_rules ?? '')) !!}

                    </div>

                </div>

                <!-- بخش امضاها -->
                <div class="row mt-5 pt-5 text-center text-dark g-3">
                    <div class="col-6">
                        <div class="border-top border-secondary pt-3 mx-4">
                            <p class="fw-bold mb-1">امضاء و شست اقامت‌کننده</p>
                            <span class="text-muted small">تایید و قبول شرایط</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border-top border-secondary pt-3 mx-4">
                            <p class="fw-bold mb-1">امضاء و مهر مدیریت</p>
                            <span class="text-muted small">صادرکننده قرارداد</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
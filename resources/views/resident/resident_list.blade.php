@extends('layouts.generalLayouts')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-xl-10">

        <div class="page-banner">
            <div class="banner-icon">
                <i class="la la-users text-white"></i>
            </div>
            <h5 class="mb-1 font-weight-bold" style="direction:rtl;">لیست ساکنین</h5>
            <p class="mb-0 text-white-75" style="direction:rtl;">فقط اطلاعات اصلی ساکن، شماره اتاق و وضعیت قرارداد نمایش داده می‌شود.</p>
        </div>

        <div class="card-soft">
            @livewire('residents-table')
        </div>

    </div>
</div>

@endsection

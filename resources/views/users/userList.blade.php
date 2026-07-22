@extends('layouts.generalLayouts')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-xl-10">
        

        <div class="page-banner">
            <div class="banner-icon">
                <i class="la la-users text-white"></i>
            </div>
            <h5 class="mb-1 font-weight-bold" style="direction:rtl;">لیست ساکنین</h5>
            <p class="mb-0 text-white-75" style="direction:rtl;">تمام ساکنین، اطلاعات اتاق و وضعیت قرارداد را در یک نگاه ببینید.</p>
        </div>

        <div class="card-soft">
            @livewire('user-list')
        </div>

    </div>
</div>
    @endsection
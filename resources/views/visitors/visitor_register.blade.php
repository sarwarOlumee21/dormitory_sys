@extends('layouts.generalLayouts')

@section('content')

@vite(['resources/css/visitors.css'])

<div class="row justify-content-center dir-rtl">
    <div class="col-12">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        {{-- بنر بالایی صفحه با استایل مدرن، یکپارچه و آبی سازمانی --}}
        <div class="top-banner mb-4">
            <div class="d-flex align-items-center">
                <div class="banner-icon ml-3">
                    <i class="la la-user-plus text-white"></i>
                </div>
                <div>
                    <h5 class="text-white mb-1 font-weight-bold">ثبت و مدیریت اطلاعات مهمان</h5>
                    <p class="mb-0 banner-caption">اطلاعات بازدیدکنندگان و مهمانان مقیم خوابگاه را به صورت دقیق ثبت نمایید</p>
                </div>
            </div>
        </div>

        {{-- styles moved to public/css/visitors.css --}}
        @livewire('resident-search-in-visitor')

    </div>
</div>

@endsection
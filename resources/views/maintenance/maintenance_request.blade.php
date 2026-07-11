@extends('layouts.generalLayouts')

@section('content')

@vite(['resources/css/maintenance.css'])

<div class="row justify-content-center dir-rtl">
    <div class="col-lg-6">

        <div class="top-banner mb-4">
            <div class="d-flex align-items-center">
                <div class="banner-icon ml-3">
                    <i class="la la-tags text-white"></i>
                </div>
                <div>
                    <h5 class="text-white mb-1 font-weight-bold">ثبت نوعیت درخواست (دمو)</h5>
                    <p class="mb-0 banner-caption">این صفحه فقط یک نمونهٔ ساده است و به دیتابیس وصل نمی‌شود.</p>
                </div>
            </div>
        </div>

        {{-- styles moved to public/css/maintenance.css --}}

        @if(session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="card custom-card">
            <div class="card-header">
                <i class="la la-plus-circle"></i>
                <span>فرم ساده ثبت نوعیت درخواست</span>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('maintenance.request.save') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="flabel" for="name">نام نوعیت درخواست</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="مثلاً درخواست برق" required>
                        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="flabel" for="description">توضیحات کوتاه</label>
                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="شرح کوتاه نوع درخواست">{{ old('description') }}</textarea>
                        @error('description')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">فعال باشد</label>
                    </div>
                    <button type="submit" class="btn btn-primary px-4 btn-maintain-primary">ذخیره (دمو)</button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection

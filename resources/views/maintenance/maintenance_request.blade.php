@extends('layouts.generalLayouts')

@section('content')

<div class="row justify-content-center" style="direction: rtl;">
    <div class="col-lg-6">

        <div class="top-banner mb-4" style="border-radius: 12px; padding: 20px; color: #ffffff;">
            <div class="d-flex align-items-center">
                <div class="banner-icon ml-3" style="background: rgba(255,255,255,0.2); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="la la-tags text-white" style="font-size:22px;"></i>
                </div>
                <div>
                    <h5 class="text-white mb-1 font-weight-bold">ثبت نوعیت درخواست (دمو)</h5>
                    <p class="mb-0" style="color:rgba(255,255,255,.75); font-size:13px;">این صفحه فقط یک نمونهٔ ساده است و به دیتابیس وصل نمی‌شود.</p>
                </div>
            </div>
        </div>

        <style>
            .custom-card {
                background: #ffffff;
                border: 1px solid #e2e8f0 !important;
                border-radius: 12px !important;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                margin-bottom: 25px;
                overflow: hidden;
            }
            .custom-card .card-header {
                background: #f8fafc;
                border-bottom: 1px solid #e2e8f0;
                padding: 15px 20px;
                font-weight: bold;
                color: #1e293b;
                display: flex;
                align-items: center;
            }
            .form-control {
                border-radius: 8px !important;
                border: 1px solid #cbd5e1 !important;
                padding: 10px 12px;
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
        </style>

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
                    <button type="submit" class="btn btn-primary px-4" style="background: #1a56db; border: none; border-radius: 8px;">ذخیره (دمو)</button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection

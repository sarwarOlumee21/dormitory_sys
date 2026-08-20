@extends('layouts.generalLayouts')

@section('content')

@vite(['resources/css/maintenance.css'])

<div class="row justify-content-center dir-rtl">
    <div class="col-12 col-xl-9">
        <div class="top-banner mb-4">
            <div class="d-flex align-items-center">
                <div class="banner-icon ml-3"><i class="la la-eye text-white"></i></div>
                <div>
                    <h5 class="text-white mb-1 font-weight-bold">جزئیات درخواست شماره {{ $maintenanceRequest->id }}</h5>
                    <p class="mb-0 banner-caption">مشاهده شرح درخواست و پاسخ مسئول مربوطه</p>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card custom-card">
            <div class="card-header"><i class="la la-info-circle"></i><span>اطلاعات درخواست</span></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3"><strong>ثبت‌کننده:</strong> {{ $maintenanceRequest->user->name ?? 'نامشخص' }}</div>
                    <div class="col-md-6 mb-3"><strong>اتاق:</strong> {{ $maintenanceRequest->room->room_number ?? 'نامشخص' }}</div>
                    <div class="col-md-6 mb-3"><strong>نوع درخواست:</strong> {{ $maintenanceRequest->requestType->name ?? 'نامشخص' }}</div>
                    <div class="col-md-6 mb-3"><strong>اولویت:</strong> {{ $maintenanceRequest->priority }}</div>
                    <div class="col-md-6 mb-3"><strong>وضعیت:</strong> {{ $maintenanceRequest->status }}</div>
                    <div class="col-md-6 mb-3"><strong>تاریخ ثبت:</strong> {{ optional($maintenanceRequest->created_at)->format('Y-m-d H:i') }}</div>
                    <div class="col-12 mb-3">
                        <strong>شرح مشکل:</strong>
                        <p class="border rounded p-3 mt-2 mb-0">{{ $maintenanceRequest->description ?: 'شرحی ثبت نشده است.' }}</p>
                    </div>
                    <div class="col-12">
                        <strong>کامنت مسئول:</strong>
                        <p class="border rounded p-3 mt-2 mb-0">{{ $maintenanceRequest->admin_comment ?: 'هنوز کامنتی ثبت نشده است.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($isManager)
            <div class="card custom-form-card">
                <div class="card-header"><i class="la la-comment"></i><span>ثبت کامنت و به‌روزرسانی وضعیت</span></div>
                <div class="card-body">
                    <form action="{{ route('maintenance.updateDetails', $maintenanceRequest) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="flabel" for="status">وضعیت</label>
                            <select class="form-control" id="status" name="status">
                                @foreach (['جدید', 'در حال بررسی', 'در حال پیگیری', 'تکمیل شده', 'تأیید شد', 'رد شد'] as $status)
                                    <option value="{{ $status }}" {{ $maintenanceRequest->status === $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="flabel" for="admin_comment">کامنت</label>
                            <textarea class="form-control" id="admin_comment" name="admin_comment" rows="4" placeholder="پاسخ یا توضیح مسئول را بنویسید...">{{ old('admin_comment', $maintenanceRequest->admin_comment) }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('maintenance.list') }}" class="btn btn-outline-secondary">بازگشت</a>
                            <button type="submit" class="btn btn-primary btn-maintain-primary"><i class="la la-save"></i> ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('maintenance.follow_up_request') }}" class="btn btn-outline-secondary">بازگشت به درخواست‌های من</a>
        @endif
    </div>
</div>

@endsection

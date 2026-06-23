@extends('layouts.generalLayouts')

@section('content')

<div class="row justify-content-center">
  <div class="col-12 col-xl-9">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="top-banner">
      <div class="banner-icon">
        <i class="la la-bed text-white" style="font-size:22px;"></i>
      </div>
      <h5 class="text-white mb-1 font-weight-bold" style="direction:rtl;">ثبت اتاق جدید</h5>
      <p class="mb-0" style="color:rgba(255,255,255,.75);font-size:13px;direction:rtl;">لطفاً اطلاعات اتاق را با دقت پُر کنید</p>
    </div>

    <div class="form-outer">
      <form class="form" action="{{ route('rooms.store') }}" method="POST">
        @csrf

        <div class="section-pill">
          <i class="la la-info-circle"></i>
          <span>اطلاعات عمومی اتاق</span>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="flabel">
              <i class="la la-hashtag"></i> شماره اتاق <span class="required-star">*</span>
            </label>
            <input type="text" id="room_number" class="finput" placeholder="مثلاً A-12" name="room_number">
          </div>

          <div class="col-md-6 mb-3">
            <label class="flabel">
              <i class="la la-users"></i> ظرفیت اتاق <span class="required-star">*</span>
            </label>
            <input type="number" id="room_capacity" class="finput" placeholder="تعداد نفرات" name="capacity" min="1">
          </div>

          <div class="col-md-6 mb-3 mb-md-0">
            <label class="flabel">
              <i class="la la-th-large"></i> نوع اتاق <span class="required-star">*</span>
            </label>
            <select id="room_type" class="finput" name="room_type">
              <option value="">-- انتخاب نوع --</option>
              <option value="study">اتاق مطالعه</option>
              <option value="sleeping">اتاق خواب</option>
              <option value="meeting">اتاق جلسه</option>
            </select>
          </div>

          <div class="col-md-6 mb-0">
            <label class="flabel">
              <i class="la la-toggle-on"></i> وضعیت اتاق <span class="required-star">*</span>
            </label>
            <select id="room_status" class="finput" name="status">
              <option value="">-- انتخاب وضعیت --</option>
              <option selected value="available">فعال</option>
              <option value="inactive">غیرفعال</option>
              <option value="maintenance">در حال تعمیر</option>
              <option value="occupied">پر</option>
            </select>
          </div>
          <div class="col-md-6 mb-0">
            <label class="flabel">
              <i class="la la-toggle-on"></i> نوت  <span class="required-star">*</span>
            </label>
            <textarea id="notes" class="finput" name="notes" placeholder="توضیحات اضافی درباره اتاق" rows="3"></textarea>
          </div>
        </div>

        <div class="sep"></div>

        <div class="d-flex justify-content-between align-items-center" style="direction:rtl;">
          <small class="text-muted">
            <i class="la la-info-circle"></i> پس از ثبت، اتاق در لیست اتاق‌ها نمایش داده می‌شود
          </small>
          <div class="d-flex gap-2">
            <a href="{{ route('rooms.list') }}" class="btn btn-outline-secondary btn-sm px-4">
              <i class="ft-x mr-1"></i> لغو
            </a>
            <button type="submit" class="btn btn-primary btn-sm px-4" style="background:#1a56db;border:none;border-radius:10px;">
              <i class="la la-check-circle mr-1"></i> ثبت اتاق
            </button>
          </div>
        </div>

      </form>
    </div>

  </div>
</div>

@endsection
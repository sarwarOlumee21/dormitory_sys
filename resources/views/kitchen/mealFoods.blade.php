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
      <h5 class="text-white mb-1 font-weight-bold" style="direction:rtl;">ثبت غذا</h5>
      <p class="mb-0" style="color:rgba(255,255,255,.75);font-size:13px;direction:rtl;">لطفاً اطلاعات غذا را با دقت پُر کنید</p>
    </div>

    <div class="form-outer">
      <form class="form" action="{{ route('mealFoods.store') }}" method="POST">
        @csrf

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="flabel">
              <i class="la la-hashtag"></i>نام غذا<span class="required-star">*</span>
            </label>
            <input type="text" id="name" class="finput" placeholder="مثلاً کباب" name="name">
          </div>
          @php
          $meals = [
            'breakfast' => 'صبحانه',
            'lunch' => 'چاشت',
            'dinner' => 'شب',
          ];
          @endphp
          <div class="col-md-6 mb-3">
            <label class="flabel">
              <i class="la la-hashtag"></i>وعده غذایی <span class="required-star">*</span>
            </label>
            <select id="meal_type" class="finput" name="meal_type">
              <option value="">انتخاب کنید</option>
              @foreach($meals as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6 mb-0">
            <label class="flabel">
              <i class="la la-toggle-on"></i> توضیحات  <span class="required-star">*</span>
            </label>
            <textarea id="description" class="finput" name="description" placeholder="توضیحات اضافی درباره غذا" rows="3"></textarea>
          </div>
        </div>

        <div class="sep"></div>

        <div class="d-flex justify-content-between align-items-center" style="direction:rtl;">
          <small class="text-muted">
            <i class="la la-info-circle"></i> پس از ثبت، اتاق در لیست اتاق‌ها نمایش داده می‌شود
          </small>
          <div class="d-flex gap-2">
            <a href="" class="btn btn-outline-secondary btn-sm px-4">
              <i class="ft-x mr-1"></i> لغو
            </a>
            <button type="submit" class="btn btn-primary btn-sm px-4" style="background:#1a56db;border:none;border-radius:10px;">
              <i class="la la-check-circle mr-1"></i> ثبت غذا
            </button>
          </div>
        </div>

      </form>
    </div>

  </div>
</div>

@endsection
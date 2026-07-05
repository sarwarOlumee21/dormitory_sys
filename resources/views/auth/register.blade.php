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
        <i class="la la-user-plus text-white" style="font-size:22px;"></i>
      </div>
      <h5 class="text-white mb-1 font-weight-bold" style="direction:rtl;">ثبت‌نام کاربر جدید</h5>
      <p class="mb-0" style="color:rgba(255,255,255,.75);font-size:13px;direction:rtl;">لطفاً اطلاعات خود را با دقت وارد کنید</p>
    </div>

    <div class="form-outer">
      <form action="{{ route('register') }}" method="POST">
        @csrf
        
        <div class="section-pill">
          <i class="la la-id-card"></i>
          <span>اطلاعات شخصی</span>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-user"></i> نام کامل <span class="required-star">*</span></label>
            <input type="text" class="finput" name="name" placeholder="نام و تخلص" value="{{ old('name') }}">
          </div>
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-envelope"></i> آدرس ایمیل <span class="required-star">*</span></label>
            <input type="email" class="finput" name="email" placeholder="example@mail.com" value="{{ old('email') }}">
          </div>
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-phone"></i> شماره تلیفون <span class="required-star">*</span></label>
            <input type="text" class="finput" name="phone" placeholder="07xx-xxx-xxxx" value="{{ old('phone') }}">
          </div>
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-map-marker"></i> شهر / ولایت</label>
            <input type="text" class="finput" name="city" placeholder="نام شهر یا ولایت" value="{{ old('city') }}">
          </div>
        </div>

        <div class="sep"></div>

        <div class="section-pill">
          <i class="la la-lock"></i>
          <span>امنیت حساب</span>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-key"></i> رمز عبور <span class="required-star">*</span></label>
            <input type="password" class="finput" name="password" placeholder="حداقل ۸ کاراکتر">
          </div>
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-check-circle"></i> تکرار رمز عبور <span class="required-star">*</span></label>
            <input type="password" class="finput" name="password_confirmation" placeholder="تکرار رمز عبور">
          </div>
        </div>

        <div class="sep"></div>

        <div class="section-pill">
          <i class="la la-info-circle"></i>
          <span>توضیحات تکمیلی</span>
        </div>

        <div class="row">
          <div class="col-12 mb-3">
            <label class="flabel"><i class="la la-comment"></i> پیام (اختیاری)</label>
            <textarea class="finput" name="bio" rows="2" placeholder="چیزی درباره خودتان بنویسید..." style="resize:vertical;">{{ old('bio') }}</textarea>
          </div>
        </div>

        <div class="sep"></div>

        <div class="d-flex justify-content-between align-items-center" style="direction:rtl;">
          <small class="text-muted"><i class="la la-info-circle"></i> فیلدهای ستاره‌دار اجباری است</small>
          <div class="d-flex gap-2">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm px-4">
              <i class="ft-x mr-1"></i> لغو
            </a>
            <button type="submit" class="btn btn-primary btn-sm px-4" style="background:#1a56db;border:none;border-radius:10px;">
              <i class="la la-check-circle mr-1"></i> ثبت‌نام
            </button>
          </div>
        </div>

      </form>
    </div>

  </div>
</div>

@endsection
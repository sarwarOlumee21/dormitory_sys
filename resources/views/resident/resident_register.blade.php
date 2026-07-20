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
      <h5 class="text-white mb-1 font-weight-bold" style="direction:rtl;">ثبت ساکن جدید</h5>
      <p class="mb-0" style="color:rgba(255,255,255,.75);font-size:13px;direction:rtl;">لطفاً اطلاعات ساکن را با دقت پُر کنید</p>
    </div>

    <div class="form-outer">
      <form action="{{ route('resident.store') }}" method="POST">
        @csrf
        <div class="section-pill">
          <i class="la la-id-card"></i>
          <span>اطلاعات شخصی</span>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-user"></i> کد <span class="required-star">*</span></label>
            <input type="text" class="finput" name="resident_code" placeholder="کد ساکن">
          </div>
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-user"></i> نام کامل <span class="required-star">*</span></label>
            <input type="text" class="finput" name="name" placeholder="نام و تخلص">
          </div>
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-male"></i> نام پدر <span class="required-star">*</span></label>
            <input type="text" class="finput" name="father_name" placeholder="نام پدر">
          </div>
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-phone"></i> شماره تلیفون <span class="required-star">*</span></label>
            <input type="text" class="finput" name="phone_number" placeholder="07xx-xxx-xxxx">
          </div>
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-map-marker"></i> شهر / ولایت</label>
            <input type="text" class="finput" name="city_name" placeholder="نام شهر یا ولایت">
          </div>
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-home"></i> شماره اتاق <span class="required-star">*</span></label>
            <select class="finput" name="room_id">
                <option value="">انتخاب کنید</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->room_number }} - {{ $room->room_type }}</option>
                @endforeach
            </select>
          </div>
        </div>

        <div class="sep"></div>

        <div class="section-pill">
          <i class="la la-briefcase"></i>
          <span>اطلاعات شغلی</span>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-building"></i> شغل</label>
            <input type="text" class="finput" name="occupation" placeholder="عنوان شغلی">
          </div>
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-phone-square"></i> شماره محل کار</label>
            <input type="text" class="finput" name="work_phone" placeholder="شماره تلیفون دفتر">
          </div>
          <div class="col-12 mb-0">
            <label class="flabel"><i class="la la-map-pin"></i> موقعیت شغل</label>
            <input type="text" class="finput" name="occupation_location" placeholder="آدرس کامل محل کار">
          </div>
        </div>

        <div class="sep"></div>

        <div class="section-pill">
          <i class="la la-user"></i>
          <span>ضامن</span>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-user"></i> نام ضامن <span class="required-star">*</span></label>
            <input type="text" class="finput" name="guarantor_name" placeholder="نام و تخلص ضامن">
          </div>
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-male"></i> نام پدر ضامن <span class="required-star">*</span></label>
            <input type="text" class="finput" name="guarantor_father_name" placeholder="نام پدر ضامن">
          </div>
          <div class="col-md-6 mb-3">
            <label class="flabel"><i class="la la-phone"></i> شماره تلیفون ضامن <span class="required-star">*</span></label>
            <input type="text" class="finput" name="guarantor_phone" placeholder="07xx-xxx-xxxx">
          </div>
          <div class="col-md-6 mb-0">
            <label class="flabel"><i class="la la-briefcase"></i>  شغل ضامن</label>
            <input type="text" class="finput" name="guarantor_occupation" placeholder="شغل ضامن">
          </div>
          <div class="col-md-6 mb-0">
            <label class="flabel"><i class="la la-briefcase"></i> موقعیت شغلی ضامن</label>
            <input type="text" class="finput" name="guarantor_occupation_location" placeholder="عنوان یا موقعیت شغلی ضامن">
          </div>
        </div>

        <div class="sep"></div>

        <div class="d-flex justify-content-between align-items-center" style="direction:rtl;">
          <small class="text-muted"><i class="la la-info-circle"></i> فیلدهای ستاره‌دار اجباری است</small>
          <div class="d-flex gap-2">
            <a href="" class="btn btn-outline-secondary btn-sm px-4">
              <i class="ft-x mr-1"></i> لغو
            </a>
            <button type="submit" class="btn btn-primary btn-sm px-4" style="background:#1a56db;border:none;border-radius:10px;">
              <i class="la la-check-circle mr-1"></i> ثبت ساکن
            </button>
          </div>
        </div>

      </form>
    </div>

  </div>
</div>

@endsection
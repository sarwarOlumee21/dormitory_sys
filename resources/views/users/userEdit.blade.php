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
                @elseif (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

            <div class="top-banner">
                <div class="banner-icon">
                    <i class="la la-user-plus text-white" style="font-size:22px;"></i>
                </div>
                <h5 class="text-white mb-1 font-weight-bold" style="direction:rtl;">ثبت ساکن جدید</h5>
                <p class="mb-0" style="color:rgba(255,255,255,.75);font-size:13px;direction:rtl;">لطفاً اطلاعات ساکن را با
                    دقت پُر کنید</p>
            </div>

            <div class="form-outer">
                <form action="{{ route('users.userUpdate', ['id' => $user->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="section-pill">
                        <i class="la la-id-card"></i>
                        <span>اطلاعات کاربران</span>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="flabel"><i class="la la-user"></i>کد کاربر <span
                                    class="required-star">*</span></label>
                            <input type="text" class="finput" name="code" placeholder="کد ساکن" value="{{ $user->code }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="flabel"><i class="la la-user"></i> نام کامل <span
                                    class="required-star">*</span></label>
                            <input type="text" class="finput" name="name" placeholder="نام و تخلص" value="{{ $user->name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="flabel"><i class="la la-phone"></i> شماره تلیفون <span
                                    class="required-star">*</span></label>
                            <input type="text" class="finput" name="number" placeholder="07xx-xxx-xxxx" value="{{ $user->number }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="flabel"><i class="la la-user"></i>نقش<span class="required-star">*</span></label>
                            <select class="finput" name="role">
                                    <option value="">انتخاب کنید</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>ادمین</option>
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>کاربر</option>
                                </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="flabel"><i class="la la-user"></i> ایمیل<span
                                    class="required-star">*</span></label>
                            <input type="email" class="finput" name="email" placeholder="ایمیل" value="{{ $user->email }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="flabel"><i class="la la-user"></i> نام کاربری <span
                                    class="required-star">*</span></label>
                            <input type="text" class="finput" name="username" placeholder="نام کاربری" value="{{ $user->username }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="flabel"><i class="la la-user"></i> رمز عبور جدید <span
                                    class="required-star">*</span></label>
                            <input type="password" class="finput" name="password" placeholder="رمز عبور" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="flabel"><i class="la la-user"></i> تأیید رمز عبور جدید <span
                                    class="required-star">*</span></label>
                            <input type="password" class="finput" name="password_confirmation" placeholder=" تأیید رمز عبور" value="">
                        </div>

                    </div>

                    <div class="sep"></div>

                    <div class="d-flex justify-content-between align-items-center" style="direction:rtl;">
                        <small class="text-muted"><i class="la la-info-circle"></i> فیلدهای ستاره‌دار اجباری است</small>
                        <div class="d-flex gap-2">
                            <a href="" class="btn btn-outline-secondary btn-sm px-4">
                                <i class="ft-x mr-1"></i> لغو
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm px-4"
                                style="background:#1a56db;border:none;border-radius:10px;">
                                <i class="la la-check-circle mr-1"></i> ثبت ساکن
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

@endsection
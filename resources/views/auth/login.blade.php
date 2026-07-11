<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ورود · صفحه دوگانه</title>
  <!-- Font Awesome 6 (رایگان) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
  <div class="login-wrapper">


    <!-- سمت راست : پنل آبی با نام کاربری و رمز عبور -->
    <div class="right-panel">
      <div class="brand">
        <h2>
          <i class="fas fa-user-circle"></i>
          ورود
        </h2>
        <p>با مشخصات خود وارد داشبورد شوید</p>
      </div>
      
  @if ($errors->any())
    <div class="alert alert-danger" style="margin-bottom: 1rem; border-radius: 12px; padding: 0.8rem 1rem;">
      {{ $errors->first() }}
    </div>
  @endif

      <form class="login-form" action="{{ route('loginform') }}" method="post">
        @csrf
        <!-- فیلد نام کاربری -->
        <div class="input-group">
          <label for="login"><i class="far fa-user" style="margin-left: 6px;"></i> ایمیل یا نام کاربری</label>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" id="login" name="login" value="{{ old('login') }}" placeholder="  ایمیل یا نام کاربری" />
          </div>
        </div>

        <!-- فیلد رمز عبور -->
        <div class="input-group">
          <label for="password"><i class="fas fa-key" style="margin-left: 6px;"></i> رمز عبور</label>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" value="password123" />
          </div>
        </div>

        <!-- موارد اضافی: یادآوری + فراموشی -->
        <div class="form-extras">
          <label class="remember">
            <input type="checkbox" checked />
            <span>مرا به خاطر بسپار</span>
          </label>
          <a href="#" class="forgot-link">رمز عبور را فراموش کرده‌اید؟</a>
        </div>

        <!-- دکمه ورود -->
        <button type="submit" class="login-btn">
          <span>ورود</span>
          <i class="fas fa-arrow-left"></i>
        </button>

        <div class="signup-hint">
          حساب کاربری ندارید؟ <a href="#">ایجاد کنید</a>
        </div>
      </form>
    </div>
    <!-- سمت چپ : وکتور / تصویر -->
    <div class="left-panel">
      <div class="vector-art">
        <!-- وکتور مدرن: ورود / دسترسی امن -->
        <svg viewBox="0 0 380 300" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x="0" y="0" width="380" height="300" rx="24" fill="transparent" />
          <!-- اشکال پس‌زمینه -->
          <circle cx="190" cy="150" r="130" fill="#dbeafe" opacity="0.3" />
          <circle cx="190" cy="150" r="100" fill="#b7d4fc" opacity="0.2" />
          <!-- مفهوم قفل / سپر -->
          <path d="M190 60L250 90V150C250 198 224 232 190 252C156 232 130 198 130 150V90L190 60Z" fill="#2563eb"
            opacity="0.15" stroke="#2563eb" stroke-width="3" />
          <path d="M190 72L238 98V150C238 190 216 220 190 238C164 220 142 190 142 150V98L190 72Z" fill="#1e4b9c"
            opacity="0.25" stroke="#1e4b9c" stroke-width="2" />
          <!-- آیکون کلید / ورود -->
          <circle cx="190" cy="160" r="32" fill="white" opacity="0.6" />
          <circle cx="190" cy="160" r="22" fill="#1a4b8c" opacity="0.2" />
          <path d="M190 148V172M190 160H208" stroke="#1a4b8c" stroke-width="4" stroke-linecap="round" />
          <circle cx="190" cy="160" r="8" fill="#1a4b8c" opacity="0.6" />
          <!-- نقطه‌های شناور -->
          <circle cx="90" cy="80" r="10" fill="#2563eb" opacity="0.08" />
          <circle cx="300" cy="220" r="14" fill="#2563eb" opacity="0.07" />
          <circle cx="70" cy="220" r="6" fill="#2563eb" opacity="0.1" />
          <circle cx="310" cy="70" r="8" fill="#2563eb" opacity="0.1" />
          <!-- قفل کوچک -->
          <rect x="270" y="110" width="36" height="28" rx="6" fill="#1a4b8c" opacity="0.15" stroke="#1a4b8c"
            stroke-width="2" />
          <path d="M282 110V98C282 92 286 88 292 88C298 88 302 92 302 98V110" stroke="#1a4b8c" stroke-width="2.5"
            stroke-linecap="round" />
          <circle cx="292" cy="124" r="4" fill="#1a4b8c" opacity="0.5" />
        </svg>
        <div class="vector-caption">
          <i class="fas fa-lock" style="margin-left: 6px; opacity:0.7;"></i> امن · خوش آمدید
        </div>
      </div>
    </div>


  </div>
</body>

</html>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ورود · صفحه دوگانه</title>
  <!-- Font Awesome 6 (رایگان) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(145deg, #e9f0fc 0%, #d6e4f5 100%);
      padding: 1.5rem;
    }

    /* کارت اصلی – دو نیمه */
    .login-wrapper {
      max-width: 1100px;
      width: 100%;
      background: white;
      border-radius: 42px;
      box-shadow: 0 30px 60px rgba(0, 20, 50, 0.20), 0 10px 30px rgba(0, 0, 0, 0.06);
      display: grid;
      grid-template-columns: 1fr 1fr;
      overflow: hidden;
      transition: all 0.2s ease;
    }

    /* ---------- سمت چپ : تصویر / وکتور ---------- */
    .left-panel {
      background: #f2f7ff;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2.5rem 1.5rem;
      min-height: 380px;
      position: relative;
    }

    .left-panel .vector-art {
      max-width: 100%;
      width: 380px;
      height: auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .vector-art svg {
      width: 100%;
      height: auto;
      display: block;
      filter: drop-shadow(0 8px 18px rgba(0, 40, 100, 0.08));
    }

    /* زیرنویس ظریف زیر وکتور */
    .vector-caption {
      margin-top: 1.25rem;
      font-size: 0.9rem;
      letter-spacing: 0.3px;
      color: #1f3a6b;
      background: rgba(255, 255, 255, 0.5);
      backdrop-filter: blur(3px);
      padding: 0.4rem 1.4rem;
      border-radius: 40px;
      font-weight: 450;
      border: 1px solid rgba(60, 100, 180, 0.10);
    }

    /* ---------- سمت راست : پنل آبی با فرم ---------- */
    .right-panel {
      background: linear-gradient(145deg, #1a4b8c, #0e3b73);
      padding: 2.8rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      color: white;
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
    }

    .right-panel .brand {
      margin-bottom: 2.2rem;
    }

    .right-panel .brand h2 {
      font-weight: 600;
      font-size: 2rem;
      letter-spacing: -0.4px;
      color: white;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .right-panel .brand h2 i {
      font-size: 2rem;
      color: #b6d4ff;
    }

    .right-panel .brand p {
      color: rgba(255, 255, 255, 0.75);
      font-size: 0.95rem;
      margin-top: 6px;
      font-weight: 400;
      letter-spacing: 0.2px;
    }

    /* فیلدهای فرم */
    .login-form {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
      margin-top: 0.5rem;
    }

    .input-group {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .input-group label {
      font-size: 0.8rem;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.4px;
      color: rgba(255, 255, 255, 0.6);
      margin-right: 4px;
    }

    .input-group .input-field {
      display: flex;
      align-items: center;
      background: rgba(255, 255, 255, 0.08);
      border-radius: 48px;
      padding: 0.2rem 1.2rem 0.2rem 0.2rem;
      border: 1px solid rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(2px);
      transition: all 0.2s ease;
    }

    .input-group .input-field:hover {
      background: rgba(255, 255, 255, 0.13);
      border-color: rgba(255, 255, 255, 0.3);
    }

    .input-group .input-field:focus-within {
      background: rgba(255, 255, 255, 0.15);
      border-color: #8bb9ff;
      box-shadow: 0 0 0 4px rgba(70, 140, 255, 0.25);
    }

    .input-field i {
      color: rgba(255, 255, 255, 0.5);
      font-size: 1rem;
      margin-left: 10px;
      transition: color 0.2s;
    }

    .input-field:focus-within i {
      color: #b6d4ff;
    }

    .input-field input {
      background: transparent;
      border: none;
      padding: 0.9rem 0.2rem 0.9rem 1rem;
      width: 100%;
      font-size: 1rem;
      color: white;
      outline: none;
      font-weight: 450;
      text-align: right;
    }

    .input-field input::placeholder {
      color: rgba(255, 255, 255, 0.4);
      font-weight: 350;
      font-size: 0.95rem;
      text-align: right;
    }

    .input-field input:-webkit-autofill {
      -webkit-box-shadow: 0 0 0 30px #1a4b8c inset !important;
      -webkit-text-fill-color: white !important;
    }

    /* ردیف اضافی: فراموشی و یادآوری */
    .form-extras {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 0.1rem;
      font-size: 0.9rem;
    }

    .remember {
      display: flex;
      align-items: center;
      gap: 8px;
      color: rgba(255, 255, 255, 0.75);
    }

    .remember input[type="checkbox"] {
      accent-color: #6ca6ff;
      width: 16px;
      height: 16px;
      cursor: pointer;
      filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.1));
    }

    .forgot-link {
      color: rgba(255, 255, 255, 0.65);
      text-decoration: none;
      font-weight: 450;
      border-bottom: 1px dotted rgba(255, 255, 255, 0.2);
      transition: all 0.2s;
    }

    .forgot-link:hover {
      color: white;
      border-bottom-color: rgba(255, 255, 255, 0.7);
    }

    /* دکمه ورود */
    .login-btn {
      margin-top: 0.5rem;
      background: white;
      border: none;
      padding: 0.95rem 1.8rem;
      border-radius: 48px;
      font-weight: 600;
      font-size: 1.05rem;
      color: #0e3b73;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      letter-spacing: 0.3px;
    }

    .login-btn i {
      font-size: 1.1rem;
      transition: transform 0.2s;
    }

    .login-btn:hover {
      background: #f0f7ff;
      transform: scale(1.02);
      box-shadow: 0 12px 28px rgba(0, 20, 50, 0.25);
    }

    .login-btn:hover i {
      transform: translateX(-5px);
    }

    .login-btn:active {
      transform: scale(0.98);
    }

    /* متن ثبت‌نام */
    .signup-hint {
      margin-top: 1.8rem;
      text-align: center;
      color: rgba(255, 255, 255, 0.6);
      font-size: 0.9rem;
      border-top: 1px solid rgba(255, 255, 255, 0.06);
      padding-top: 1.5rem;
    }

    .signup-hint a {
      color: white;
      font-weight: 500;
      text-decoration: none;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      margin-right: 5px;
      transition: border 0.2s;
    }

    .signup-hint a:hover {
      border-bottom-color: white;
    }

    /* ---------- ریسپانسیو ---------- */
    @media (max-width: 780px) {
      .login-wrapper {
        grid-template-columns: 1fr;
        border-radius: 32px;
      }

      .left-panel {
        padding: 2rem 1.5rem 1.5rem;
        min-height: 220px;
        background: #eaf2fd;
        order: 2;
      }

      .right-panel {
        order: 1;
        padding: 2.2rem 1.8rem;
        border-radius: 32px 32px 0 0;
      }

      .vector-art {
        max-width: 200px;
      }

      .vector-caption {
        font-size: 0.8rem;
        padding: 0.2rem 1.2rem;
        margin-top: 0.8rem;
      }

      .right-panel .brand h2 {
        font-size: 1.8rem;
      }

      .login-btn {
        padding: 0.8rem 1.5rem;
      }
    }

    @media (max-width: 450px) {
      .right-panel {
        padding: 1.8rem 1.2rem;
      }

      .form-extras {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }

      .input-field input {
        font-size: 0.95rem;
        padding: 0.75rem 0.2rem 0.75rem 0.8rem;
      }
    }
  </style>
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
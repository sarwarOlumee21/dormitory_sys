<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

      <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
        <a href="{{ route('home') }}">
          <i class="la la-home"></i>
          <span class="menu-title">داشبورد</span>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('resident.*') ? 'active open' : '' }}">
        <a href="#"><i class="la la-users"></i><span class="menu-title">ساکنین لیلیه</span></a>
        <ul class="menu-content">
          <li class="{{ request()->routeIs('resident.register') ? 'active' : '' }}">
            <a href="{{ route('resident.register') }}">ثبت ساکن</a>
          </li>
          <li class="{{ request()->routeIs('resident.list') ? 'active' : '' }}">
            <a href="{{ route('resident.list') }}">لیست ساکنین</a>
          </li>
        </ul>
      </li>

      <li class="nav-item {{ request()->routeIs('rooms.*') ? 'active open' : '' }}">
        <a href="#"><i class="la la-bed"></i><span class="menu-title">مدیریت اتاق‌ها</span></a>
        <ul class="menu-content">
          <li class="{{ request()->routeIs('rooms.register') ? 'active' : '' }}">
            <a href="{{ route('rooms.register') }}">ثبت اتاق</a>
          </li>
          <li class="{{ request()->routeIs('rooms.list') ? 'active' : '' }}">
            <a href="{{ route('rooms.list') }}">لیست اتاق‌ها</a>
          </li>
        </ul>
      </li>

      <li class="nav-item {{ request()->routeIs('contracts.*') ? 'active open' : '' }}">
        <a href="#"><i class="la la-file-text"></i><span class="menu-title">مدیریت قراردادها</span></a>
        <ul class="menu-content">
          <li class="{{ request()->routeIs('contracts.register') ? 'active' : '' }}">
            <a href="{{ route('contracts.register') }}">ثبت قرارداد</a>
          </li>
          <li class="{{ request()->routeIs('contracts.rules') ? 'active' : '' }}">
            <a href="{{ route('contracts.rules') }}">ثبت قوانین</a>
          </li>
          <li class="{{ request()->routeIs('contracts.list') ? 'active' : '' }}">
            <a href="{{ route('contracts.list') }}">لیست قراردادها</a>
          </li>
        </ul>
      </li>

      <li class="nav-item {{ request()->routeIs('visitors.*') ? 'active open' : '' }}">
        <a href="#"><i class="la la-user-plus"></i><span class="menu-title">مهمان‌ها</span></a>
        <ul class="menu-content">
          <li class="{{ request()->routeIs('visitors.register') ? 'active' : '' }}">
            <a href="{{ route('visitors.register') }}">ثبت مهمان</a>
          </li>
          <li class="{{ request()->routeIs('visitors.list') ? 'active' : '' }}">
            <a href="{{ route('visitors.list') }}">لیست مهمان‌ها</a>
          </li>
        </ul>
      </li>

      <li class="nav-item {{ request()->routeIs('maintenance.*') ? 'active open' : '' }}">
        <a href="#"><i class="la la-wrench"></i><span class="menu-title">تعمیرات و درخواست‌ها</span></a>
        <ul class="menu-content">
          <li class="">
            <a href="">ثبت درخواست</a>
          </li>
          <li class="{{ request()->routeIs('maintenance.list') ? 'active' : '' }}">
            <a href="{{ route('maintenance.list') }}">لیست درخواست‌ها</a>
          </li>
          <li class="{{ request()->routeIs('maintenance.request') ? 'active' : '' }}">
            <a href="{{ route('maintenance.request') }}"> ثبت نوعیت درخواست </a>
          </li>
        </ul>
      </li>

      <li class="nav-item {{ request()->routeIs('announcements.*') ? 'active open' : '' }}">
        <a href="#"><i class="la la-bullhorn"></i><span class="menu-title">اعلانات</span></a>
        <ul class="menu-content">
          <li class="{{ request()->routeIs('announcements.register') ? 'active' : '' }}">
            <a href="{{ route('announcements.register') }}">ثبت اعلان</a>
          </li>
          <li class="{{ request()->routeIs('announcements.list') ? 'active' : '' }}">
            <a href="{{ route('announcements.list') }}">لیست اعلانات</a>
          </li>
        </ul>
      </li>

      <li class="{{ request()->routeIs('reports.index') ? 'active' : '' }}">
        <a href="{{ route('reports.index') }}">
          <i class="la la-bar-chart"></i>
          <span class="menu-title">گزارشات</span>
        </a>
      </li>

    </ul>
  </div>
</div>

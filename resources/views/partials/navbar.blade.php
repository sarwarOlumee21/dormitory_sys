<nav
  class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-light navbar-shadow">
  <div class="navbar-wrapper">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
            href="#"><i class="ft-menu font-large-1"></i></a></li>
        <li class="nav-item mr-auto">
          <a class="navbar-brand" href="index.html">
            <img class="brand-logo" alt="modern admin logo" src="../../../app-assets/images/logo/logo.png">
            <h3 class="brand-text">Modern Admin</h3>
          </a>
        </li>
        <li class="nav-item d-none d-md-block float-right"><a class="nav-link modern-nav-toggle pr-0"
            data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 black"
              data-ticon="ft-toggle-right"></i></a></li>
        <li class="nav-item d-md-none">
          <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
              class="la la-ellipsis-v"></i></a>
        </li>
      </ul>
    </div>
    <div class="navbar-container content">
      <div class="collapse navbar-collapse d-flex justify-content-end" id="navbar-mobile">

        <ul class="nav navbar-nav float-right ">

          @php
            $canViewRequestNotifications = auth()->check()
              && in_array(auth()->user()->role, ['admin', 'manager', 'staff'])
              && \Illuminate\Support\Facades\Schema::hasTable('maintenance_requests');
            $notificationRequests = $canViewRequestNotifications
              ? \App\Models\MaintenanceRequest::with(['user', 'requestType', 'room'])
                ->where('is_active', true)
                ->whereNull('notification_read_at')
                ->latest()
                ->take(10)
                ->get()
              : collect();
            $notificationCount = $canViewRequestNotifications
              ? \App\Models\MaintenanceRequest::where('is_active', true)->whereNull('notification_read_at')->count()
              : 0;
          @endphp

          <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag"
              href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                class="flag-icon flag-icon-gb"></i><span class="selected-language"></span></a>
            <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#"><i
                  class="flag-icon flag-icon-gb"></i> English</a>
              <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a>
              <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> Chinese</a>
              <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> German</a>
            </div>
          </li>
          <li class="dropdown dropdown-notification nav-item">
            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i>
              @if ($notificationCount > 0)
                <span
                  class="badge badge-pill badge-default badge-danger badge-up badge-glow">{{ $notificationCount }}</span>
              @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
              <li class="dropdown-menu-header">
                <h6 class="dropdown-header m-0">
                  <span class="grey darken-2">درخواست‌های جدید</span>
                </h6>
                <span class="notification-tag badge badge-default badge-danger float-right m-0">{{ $notificationCount }}
                  جدید</span>
              </li>
              <li class="scrollable-container media-list w-100">
                @forelse ($notificationRequests as $maintenanceRequest)
                  <a href="{{ route('maintenance.notification.read', $maintenanceRequest) }}">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i>
                      </div>
                      <div class="media-body">
                        <h6 class="media-heading">درخواست شماره {{ $maintenanceRequest->id }}</h6>
                        <p class="notification-text font-small-3 text-muted">
                          {{ $maintenanceRequest->user->name ?? 'کاربر نامشخص' }}،
                          {{ $maintenanceRequest->requestType->name ?? 'درخواست تعمیر' }}
                        </p>
                        <small>
                          <time class="media-meta text-muted"
                            datetime="{{ $maintenanceRequest->created_at->toIso8601String() }}">{{ $maintenanceRequest->created_at->diffForHumans() }}</time>
                        </small>
                      </div>
                    </div>
                  </a>
                @empty
                  <div class="p-2 text-center text-muted">درخواست جدیدی وجود ندارد.</div>
                @endforelse
              </li>
              <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                  href="{{ route('maintenance.list') }}">مشاهده همه درخواست‌ها</a></li>
            </ul>
          </li>
          <li class="dropdown dropdown-notification nav-item">
            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-mail"> </i></a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
              <li class="dropdown-menu-header">
                <h6 class="dropdown-header m-0">
                  <span class="grey darken-2">Messages</span>
                </h6>
                <span class="notification-tag badge badge-default badge-warning float-right m-0">4 New</span>
              </li>
              <li class="scrollable-container media-list w-100">
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left">
                      <span class="avatar avatar-sm avatar-online rounded-circle">
                        <img src="../../../app-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><i></i></span>
                    </div>
                    <div class="media-body">
                      <h6 class="media-heading">Margaret Govan</h6>
                      <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start.</p>
                      <small>
                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time>
                      </small>
                    </div>
                  </div>
                </a>
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left">
                      <span class="avatar avatar-sm avatar-busy rounded-circle">
                        <img src="../../../app-assets/images/portrait/small/avatar-s-2.png" alt="avatar"><i></i></span>
                    </div>
                    <div class="media-body">
                      <h6 class="media-heading">Bret Lezama</h6>
                      <p class="notification-text font-small-3 text-muted">I have seen your work, there is</p>
                      <small>
                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Tuesday</time>
                      </small>
                    </div>
                  </div>
                </a>
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left">
                      <span class="avatar avatar-sm avatar-online rounded-circle">
                        <img src="../../../app-assets/images/portrait/small/avatar-s-3.png" alt="avatar"><i></i></span>
                    </div>
                    <div class="media-body">
                      <h6 class="media-heading">Carie Berra</h6>
                      <p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p>
                      <small>
                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Friday</time>
                      </small>
                    </div>
                  </div>
                </a>
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left">
                      <span class="avatar avatar-sm avatar-away rounded-circle">
                        <img src="../../../app-assets/images/portrait/small/avatar-s-6.png" alt="avatar"><i></i></span>
                    </div>
                    <div class="media-body">
                      <h6 class="media-heading">Eric Alsobrook</h6>
                      <p class="notification-text font-small-3 text-muted">We have project party this saturday.</p>
                      <small>
                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">last month</time>
                      </small>
                    </div>
                  </div>
                </a>
              </li>
              <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                  href="javascript:void(0)">Read all messages</a></li>
            </ul>
          </li>
          <li class="dropdown dropdown-user nav-item">
            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
              <span class="mr-1">
                <span
                  class="user-name text-bold-700">{{ auth()->user()->name ?? auth()->user()->username ?? auth()->user()->email }}</span>
              </span>
              <span class="avatar avatar-online">
                <img
                  src="{{ auth()->user()->profile_image_url ? asset('storage/' . auth()->user()->profile_image_url) : asset('app-assets/images/portrait/small/avatar-s-19.png') }}"
                  alt="{{ auth()->user()->name ?? 'avatar' }}"><i></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"><i class="ft-user"></i>
                Edit Profile</a>
              <a class="dropdown-item" href="#"><i class="ft-mail"></i> My Inbox</a>
              <a class="dropdown-item" href="#"><i class="ft-check-square"></i> Task</a>
              <a class="dropdown-item" href="#"><i class="ft-message-square"></i> Chats</a>
              <div class="dropdown-divider"></div>

              <a class="dropdown-item" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="ft-power"></i> Logout
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
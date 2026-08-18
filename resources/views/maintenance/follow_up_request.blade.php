@extends('layouts.generalLayouts')

@section('content')

@vite(['resources/css/maintenance.css'])

<div class="row dir-rtl">
    <div class="col-12">

        {{-- بنر بالایی --}}
        <div class="top-banner mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between">

                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <div class="banner-icon ml-3">
                        <i class="la la-clipboard-check text-white"></i>
                    </div>

                    <div>
                        <h5 class="text-white mb-1 font-weight-bold">
                            درخواست‌های من
                        </h5>

                        <p class="mb-0 banner-caption">
                            درخواست‌های ثبت‌شده خود را مشاهده و وضعیت رسیدگی به آن‌ها را پیگیری کنید
                        </p>
                    </div>
                </div>

                <div>
                    <a href="{{ route('maintenance.request') }}"
                       class="btn btn-white text-primary font-weight-bold px-4 btn-maintain-white">

                        <i class="la la-plus ml-1 icon-sm"></i>
                        ثبت درخواست جدید

                    </a>
                </div>

            </div>
        </div>


        {{-- خلاصه وضعیت درخواست‌ها --}}
        <div class="row mb-4">

            {{-- کل درخواست‌ها --}}
            <div class="col-md-3 mb-3">
                <div class="card custom-card h-100">
                    <div class="card-body d-flex align-items-center">

                        <div class="banner-icon ml-3"
                             style="background: rgba(0, 123, 255, .1);">
                            <i class="la la-list text-primary"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">
                                کل درخواست‌ها
                            </small>

                            <h4 class="font-weight-bold mb-0">
                                {{ $stats['all'] ?? 0 }}
                            </h4>
                        </div>

                    </div>
                </div>
            </div>


            {{-- در حال بررسی --}}
            <div class="col-md-3 mb-3">
                <div class="card custom-card h-100">
                    <div class="card-body d-flex align-items-center">

                        <div class="banner-icon ml-3"
                             style="background: rgba(255, 193, 7, .1);">
                            <i class="la la-hourglass-half text-warning"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">
                                در حال بررسی
                            </small>

                            <h4 class="font-weight-bold mb-0">
                                {{ $stats['pending'] ?? 0 }}
                            </h4>
                        </div>

                    </div>
                </div>
            </div>


            {{-- در حال پیگیری --}}
            <div class="col-md-3 mb-3">
                <div class="card custom-card h-100">
                    <div class="card-body d-flex align-items-center">

                        <div class="banner-icon ml-3"
                             style="background: rgba(23, 162, 184, .1);">
                            <i class="la la-refresh text-info"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">
                                در حال پیگیری
                            </small>

                            <h4 class="font-weight-bold mb-0">
                                {{ $stats['in_progress'] ?? 0 }}
                            </h4>
                        </div>

                    </div>
                </div>
            </div>


            {{-- تکمیل شده --}}
            <div class="col-md-3 mb-3">
                <div class="card custom-card h-100">
                    <div class="card-body d-flex align-items-center">

                        <div class="banner-icon ml-3"
                             style="background: rgba(40, 167, 69, .1);">
                            <i class="la la-check-circle text-success"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">
                                تکمیل شده
                            </small>

                            <h4 class="font-weight-bold mb-0">
                                {{ $stats['done'] ?? 0 }}
                            </h4>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        {{-- جدول درخواست‌های کاربر --}}
        <div class="card custom-card">

            <div class="card-header bg-white border-0 py-3">

                <div class="d-flex align-items-center justify-content-between">

                    <div>
                        <h6 class="font-weight-bold mb-1">
                            درخواست‌های ثبت‌شده من
                        </h6>

                        <small class="text-muted">
                            در این قسمت می‌توانید وضعیت درخواست‌های خود را مشاهده کنید.
                        </small>
                    </div>

                </div>

            </div>


            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نوع درخواست</th>
                            <th>نمبر اتاق</th>
                            <th>اولویت</th>
                            <th>تاریخ ثبت</th>
                            <th>وضعیت</th>
                            <th class="text-center">جزئیات</th>
                        </tr>
                    </thead>


                    <tbody>
                        @forelse ($maintenanceRequests as $request)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="font-weight-bold">
                                    {{ $request->requestType->name ?? 'نامشخص' }}
                                </td>

                                <td>
                                    <span class="badge-room">
                                        {{ $request->room->room_number ?? 'نامشخص' }}
                                    </span>
                                </td>

                                <td>
                                    @php
                                        $priorityClass = 'badge';
                                        $priorityIcon = '';
                                        if ($request->priority == 'high' || $request->priority == 'فوری' || $request->priority == 'فوری و اضطراری') {
                                            $priorityClass = 'badge-prio-danger';
                                            $priorityIcon = '<i class="la la-exclamation-circle"></i> ';
                                        } elseif ($request->priority == 'medium' || $request->priority == 'متوسط') {
                                            $priorityClass = 'badge';
                                            $priorityIcon = '<i class="la la-exclamation-circle"></i> ';
                                            $priorityStyle = 'background: #fff3cd; color: #856404;';
                                        } else {
                                            $priorityClass = 'badge';
                                            $priorityStyle = 'background: #fff3cd; color: #856404;';
                                        }
                                    @endphp

                                    <span class="{{ $priorityClass }}" @if(!empty($priorityStyle)) style="{{ $priorityStyle }}" @endif>
                                        {!! $priorityIcon !!}
                                        {{ $request->priority ?? 'نامشخص' }}
                                    </span>
                                </td>

                                <td dir="ltr" class="text-left">
                                    {{ optional($request->created_at)->format('Y-m-d H:i') ?? '-' }}
                                </td>

                                <td>
                                    @php
                                        $statusClass = 'badge-status-pending';
                                        $statusStyle = '';
                                        $status = $request->status ?? 'نامشخص';

                                        if (in_array($status, ['در حال پیگیری', 'در حال پیگیری'])) {
                                            $statusClass = 'badge';
                                            $statusStyle = 'background: #dff6ff; color: #087990;';
                                        } elseif (in_array($status, ['تکمیل شده', 'تأیید شد'])) {
                                            $statusClass = 'badge';
                                            $statusStyle = 'background: #d4edda; color: #155724;';
                                        } elseif ($status == 'رد شد') {
                                            $statusClass = 'badge';
                                            $statusStyle = 'background: #f8d7da; color: #721c24;';
                                        }
                                    @endphp

                                    <span class="{{ $statusClass }}" @if(!empty($statusStyle)) style="{{ $statusStyle }}" @endif>
                                        {{ $status }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <button class="btn btn-outline-primary btn-sm" title="مشاهده جزئیات">
                                        <i class="la la-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    هیچ درخواستی برای شما ثبت نشده است.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>


            {{-- Footer --}}
            <div class="card-footer bg-light d-flex align-items-center justify-content-between flex-wrap py-3 card-footer-maintain">

                <span class="text-muted font-small-3">
                    <i class="la la-info-circle text-primary"></i>
                    وضعیت درخواست‌ها توسط مسئول مربوطه به‌روزرسانی می‌شود.
                </span>

                <span class="text-muted font-small-3">
                    برای ثبت درخواست جدید از دکمه بالای صفحه استفاده کنید.
                </span>

            </div>

        </div>

    </div>
</div>

@endsection
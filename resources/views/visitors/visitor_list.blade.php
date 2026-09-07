@extends('layouts.generalLayouts')

@section('content')

    @vite(['resources/css/visitors.css'])

    <div class="row dir-rtl">
        <div class="col-12">

            {{-- بنر بالایی صفحه با استایل مدرن، مینیمال و یکپارچه --}}
            <div class="top-banner mb-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <div class="banner-icon ml-3 mr-1">
                            <i class="la la-users text-white"></i>
                        </div>
                        <div>
                            <h5 class="text-white mb-1 font-weight-bold">مدیریت و لیست مهمانان</h5>
                            <p class="mb-0 banner-caption">مشاهده وضعیت حضور، ثبت خروج و تاریخچه رفت‌وامد مهمانان</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('visitors.register') }}"
                            class="btn btn-white text-primary font-weight-bold px-4 btn-maintain-white">
                            <i class="la la-plus ml-1 icon-sm"></i> ثبت مهمان جدید
                        </a>
                    </div>
                </div>
            </div>

            {{-- styles moved to public/css/visitors.css --}}

            {{-- جدول نمایش داده‌ها درون کارد مینیمال --}}
            <div class="card custom-card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام مهمان</th>
                                <th>ساکن میزبان</th>
                                <th>نمبر اتاق</th>
                                <th>تاریخ و ساعت ورود</th>
                                <th>تاریخ و ساعت خروج</th>
                                <th>وضعیت حضور</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- ردیف اول --}}
                            @foreach ($visitors as $visitor)
                                <tr>
                                    <td>{{ $visitor->id }}</td>
                                    <td class="font-weight-bold">{{ $visitor->guest_name }}</td>
                                    <td>{{ $visitor->resident->name ?? 'نام میزبان در دسترس نیست' }}</td>
                                    <td><span
                                            class="badge-custom-blue">{{ $visitor->room->room_number ?? 'نمبر اتاق در دسترس نیست' }}</span>
                                    </td>
                                    <td dir="ltr" class="text-right">{{ $visitor->check_in_at }}</td>
                                    <td class="text-muted">{{ $visitor->check_out_at ?? '-' }}</td>
                                    <td>
                                        <span class="badge-custom-blue">
                                            <i class="la la-sign-in"></i>
                                            {{ $visitor->attendance_status ?? 'داخل خوابگاه' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-action-out" data-toggle="modal"
                                            data-target="#checkoutModal" data-visitor-id="{{ $visitor->id }}">
                                            <i class="la la-sign-out"></i>
                                            ثبت خروج
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div
                    class="card-footer bg-light d-flex align-items-center justify-content-between flex-wrap py-3 card-footer-maintain">
                    <span class="text-muted font-small-3">نمایش لیست فعال مهمانان</span>
                    <span class="text-muted font-small-3">
                        <i class="la la-info-circle text-primary"></i> برای ثبت مهمان جدید از دکمه بالا استفاده کنید.
                    </span>
                </div>
            </div>

        </div>
    </div>

<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content" style="border-radius:15px; direction:rtl;">

            <form action="{{ route('visitors.leave') }}"
                  method="POST">

                @csrf

                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">
                        ثبت خروج اقامت‌کننده
                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <input type="hidden" name="visitor_id" id="visitor_id">

                <div class="modal-body">

                    <div class="form-group">
                        <label class="font-weight-bold">
                            تاریخ خروج
                        </label>

                        <input type="date"
                               name="check_out_at"
                               id="check_out_at"
                               class="form-control"
                               value="{{ date('Y-m-d') }}"
                               required>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        لغو
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="la la-check"></i>
                        تأیید و ثبت خروج
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkoutModal = document.getElementById('checkoutModal');
        const visitorIdInput = document.getElementById('visitor_id');

        checkoutModal.addEventListener('show.bs.modal', function (event) {
            const triggerButton = event.relatedTarget;
            const visitorId = triggerButton.getAttribute('data-visitor-id');
            visitorIdInput.value = visitorId;
        });
    });
</script>

@endsection
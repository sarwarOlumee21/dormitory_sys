@extends('layouts.generalLayouts')

@section('content')

@vite(['resources/css/maintenance.css'])

<div class="row dir-rtl">
    <div class="col-12">

        {{-- بنر بالایی صفحه با استایل مدرن، مینیمال و یکپارچه --}}
        <div class="top-banner mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <div class="banner-icon ml-3">
                        <i class="la la-server text-white"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-1 font-weight-bold">لیست اتاق‌ها</h5>
                        <p class="mb-0 banner-caption">لیست ظرفیت و وضعیت اتاق‌های خوابگاه اندیشه</p>
                    </div>
                </div>
                <div>
                    <a href="{{ route('rooms.register') }}" class="btn btn-white text-primary font-weight-bold px-4 btn-maintain-white">
                        <i class="la la-plus ml-1 icon-sm"></i> ثبت اتاق جدید
                    </a>
                </div>
            </div>
        </div>

        {{-- جدول نمایش داده‌ها درون کارد مینیمال --}}
        <div class="card custom-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام اتاق</th>
                            <th>ظرفیت کل</th>
                            <th>ظرفیت فعلی</th>
                            <th>وضعیت اتاق</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rooms as $room)

                            @php
                                // تعداد افراد فعلی داخل اتاق
                                $currentResidents = $room->capacity - $room->remaining_capacity;
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="font-weight-bold">
                                    <span class="badge-room">{{ $room->room_number }}</span>
                                </td>

                                <td>
                                    {{ $room->capacity }}
                                    <small class="text-muted">نفر</small>
                                </td>

                                <td>
                                    {{ $room->current_capacity }}
                                    <small class="text-muted">نفر</small>
                                </td>

                                <td>
                                    @if ($room->room_status == 'پر')
                                        <span class="room-status-badge room-status-full">
                                            <i class="la la-times-circle"></i> پر
                                        </span>
                                    @elseif ($room->room_status == 'دارای ظرفیت')
                                        <span class="room-status-badge room-status-available">
                                            <i class="la la-check-circle"></i> دارای ظرفیت
                                        </span>
                                    @elseif ($room->room_status == 'خالی')
                                        <span class="room-status-badge room-status-empty">
                                            <i class="la la-circle"></i> خالی
                                        </span>
                                    @else
                                        <span class="room-status-badge room-status-active">
                                            <i class="la la-bolt"></i> فعال
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('rooms.edit', ['id' => $room->id]) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="la la-edit"></i> ویرایش
                                    </a>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="la la-inbox font-large-2 d-block mb-2"></i>
                                    هیچ اتاقی ثبت نشده است.
                                </td>
                            </tr>

                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-light d-flex align-items-center justify-content-between flex-wrap py-3 card-footer-maintain">
                <span class="text-muted font-small-3">نمایش لیست کل اتاق‌های ثبت‌شده</span>
                <span class="text-muted font-small-3">
                    <i class="la la-info-circle text-primary"></i> برای ثبت اتاق جدید از دکمه بالا استفاده کنید.
                </span>
            </div>
        </div>

    </div>
</div>

<style>
    .room-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 700;
        line-height: 1;
        white-space: nowrap;
    }

    .room-status-badge i {
        font-size: 13px;
    }

    /* پر - قرمز */
    .room-status-full {
        background-color: #fde8e8;
        color: #c81e1e;
    }

    /* دارای ظرفیت - نارنجی/زرد */
    .room-status-available {
        background-color: #fef3c7;
        color: #92400e;
    }

    /* خالی - خاکستری */
    .room-status-empty {
        background-color: #f1f5f9;
        color: #475569;
    }

    /* فعال - سبز */
    .room-status-active {
        background-color: #def7ec;
        color: #03543f;
    }
</style>

@endsection
```blade
@extends('layouts.generalLayouts')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-xl-11">

        {{-- Header --}}
        <div class="top-banner d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <div class="banner-icon">
                    <i class="la la-server text-white" style="font-size:22px;"></i>
                </div>

                <h5 class="text-white mb-1 font-weight-bold" style="direction:rtl;">
                    لیست اتاق‌ها
                </h5>

                <p class="mb-0"
                   style="color:rgba(255,255,255,.75);font-size:13px;direction:rtl;">
                    لیست ظرفیت و وضعیت اتاق‌های خوابگاه اندیشه
                </p>
            </div>

            <div>
                <a href="{{ route('rooms.register') }}"
                   class="btn btn-light btn-sm px-4 py-2 font-weight-bold"
                   style="border-radius:10px; color:#1a56db;">

                    <i class="la la-plus-circle font-medium-2"></i>
                    ثبت اتاق جدید

                </a>
            </div>

        </div>


        {{-- Table --}}
        <div class="form-outer">

            <div class="table-responsive"
                 style="border:1px solid #e2e8f0; border-radius:12px; overflow:hidden;">

                <table class="table table-hover mb-0"
                       style="direction:rtl; text-align:right;">

                    <thead style="background:#f1f5f9; border-bottom:2px solid #e2e8f0;">

                        <tr>

                            <th class="border-0 font-weight-bold"
                                style="color:#475569;">
                                #
                            </th>

                            <th class="border-0 font-weight-bold"
                                style="color:#475569;">
                                نام اتاق
                            </th>

                            <th class="border-0 font-weight-bold"
                                style="color:#475569;">
                                ظرفیت کل
                            </th>

                            <th class="border-0 font-weight-bold"
                                style="color:#475569;">
                                ظرفیت فعلی
                            </th>

                            <th class="border-0 font-weight-bold"
                                style="color:#475569;">
                                وضعیت اتاق
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($rooms as $room)

                            @php
                                // تعداد افراد فعلی داخل اتاق
                                $currentResidents = $room->capacity - $room->remaining_capacity;
                            @endphp

                            <tr>

                                {{-- شماره --}}
                                <td class="align-middle">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- نام / شماره اتاق --}}
                                <td class="align-middle">

                                    <span class="badge badge-pill badge-light border px-3 py-2 font-weight-bold text-primary">
                                        {{ $room->room_number }}
                                    </span>

                                </td>


                                {{-- ظرفیت کل --}}
                                <td class="align-middle">

                                    <span class="font-weight-bold text-dark">
                                        {{ $room->capacity }}
                                    </span>

                                    <small class="text-muted">
                                        نفر
                                    </small>

                                </td>


                                {{-- ظرفیت فعلی / افراد فعلی --}}
                                <td class="align-middle">

                                    <span class="font-weight-bold text-dark">
                                        {{ $room->current_capacity }}
                                    </span>

                                    <small class="text-muted">
                                        نفر
                                    </small>

                                </td>

                                {{-- وضعیت --}}
                                <td class="align-middle">

                                    @if ($room->room_status == 'پر')

                                        <span class="badge badge-danger px-3 py-2"
                                              style="border-radius:6px;">
                                            پر
                                        </span>

                                    @elseif ($room->room_status == 'دارای ظرفیت')

                                        <span class="badge badge-warning px-3 py-2"
                                              style="border-radius:6px;">
                                             دارای ظرفیت
                                        </span>

                                    @elseif ($room->room_status == 'خالی')

                                        <span class="badge badge-secondary px-3 py-2"
                                              style="border-radius:6px;">
                                            خالی
                                        </span>

                                    @else

                                        <span class="badge badge-success px-3 py-2"
                                              style="border-radius:6px;">
                                            فعال
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted py-5">

                                    <i class="la la-inbox font-large-2 d-block mb-2"></i>

                                    هیچ اتاقی ثبت نشده است.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>

@endsection

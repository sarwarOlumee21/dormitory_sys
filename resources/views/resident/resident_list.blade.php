@extends('layouts.generalLayouts')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-xl-10">

        <div class="page-banner">
            <div class="banner-icon">
                <i class="la la-users text-white"></i>
            </div>
            <h5 class="mb-1 font-weight-bold" style="direction:rtl;">لیست ساکنین</h5>
            <p class="mb-0 text-white-75" style="direction:rtl;">فقط اطلاعات اصلی ساکن، شماره اتاق و وضعیت قرارداد نمایش داده می‌شود.</p>
        </div>

        <div class="card-soft">

            <div class="filter-card p-3 mb-4">
                <div class="row gx-2 gy-2 align-items-end">
                    <div class="col-md-10">
                        <label class="form-label fw-bold" style="direction:rtl;">جستجو</label>
                        <input type="text" id="filterResident" class="form-control border-primary" placeholder="نام، اتاق، تلفن...">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary btn-block" id="btnFilterResident">
                            <i class="la la-search"></i> جستجو
                        </button>
                    </div>
                </div>
            </div>

            @php
                $residentsList = $residents ?? [
                    (object)[
                        'resident_code' => 'R-1001',
                        'name' => 'علی رضایی',
                        'phone_number' => '09123456789',
                        'room_number' => '101',
                        'status' => 'فعال',
                    ],
                    (object)[
                        'resident_code' => 'R-1002',
                        'name' => 'مینا احمدی',
                        'phone_number' => '09122334455',
                        'room_number' => '102',
                        'status' => 'تمدید نشده',
                    ],
                ];
            @endphp

            @if (!isset($residents))
                <div class="alert alert-info mx-3">این نسخه برای نمایش بدون بک‌اند آماده شده است. اطلاعات نمونه هستند.</div>
            @endif

            <div class="table-responsive" style="overflow-x:auto !important;">
                <table class="table table-striped table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>کد</th>
                            <th>نام کامل</th>
                            <th>شماره تلیفون</th>
                            <th>نمبر اتاق</th>
                            <th>وضعیت قرارداد</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody id="residentsBody">
                        @forelse ($residentsList as $index => $resident)
                            <tr data-search="{{ $resident->name }} {{ $resident->room_number ?? '' }} {{ $resident->phone_number }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $resident->resident_code ?? '-' }}</td>
                                <td>{{ $resident->name ?? '-' }}</td>
                                <td>{{ $resident->phone_number ?? '-' }}</td>
                                <td>{{ $resident->room_number ?? 'بدون اتاق' }}</td>
                                <td>{{ $resident->status ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('resident.list.details', ['id' => $resident->id]) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="la la-eye"></i> جزئیات
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">هیچ ساکنی برای نمایش وجود ندارد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 mb-3 d-flex justify-content-center">
                @if (isset($residents) && is_object($residents) && method_exists($residents, 'links'))
                    {!! $residents->links() !!}
                @endif
            </div>

        </div>

    </div>
</div>

<script>
    document.getElementById('btnFilterResident').addEventListener('click', function () {
        var q = (document.getElementById('filterResident').value || '').trim().toLowerCase();
        var rows = document.querySelectorAll('#residentsBody tr[data-search]');
        var n = 0;
        rows.forEach(function (row) {
            var show = !q || row.getAttribute('data-search').toLowerCase().indexOf(q) !== -1;
            row.style.display = show ? '' : 'none';
            if (show) { n++; row.cells[0].textContent = n; }
        });
    });
    document.getElementById('filterResident').addEventListener('keyup', function (e) {
        if (e.key === 'Enter') document.getElementById('btnFilterResident').click();
    });
</script>

@endsection

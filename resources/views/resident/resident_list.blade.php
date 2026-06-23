@extends('layouts.generalLayouts')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-xl-10">
        

        <div class="page-banner">
            <div class="banner-icon">
                <i class="la la-users text-white"></i>
            </div>
            <h5 class="mb-1 font-weight-bold" style="direction:rtl;">لیست ساکنین</h5>
            <p class="mb-0 text-white-75" style="direction:rtl;">تمام ساکنین، اطلاعات اتاق و وضعیت قرارداد را در یک نگاه ببینید.</p>
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

            <div class="table-responsive" style="overflow-x:auto !important;">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>کد</th>
                            <th>نام کامل</th>
                            <th>نام پدر</th>
                            <th>شهر</th>
                            <th>شماره تلیفون</th>
                            <th>نمبر اتاق</th>
                            <th>شغل</th>
                            <th>موقعیت شغل</th>
                            <th>شماره تلیفون کار</th>
                            <th>نام ضامن  </th>
                            <th>نام پدر ضامن  </th>
                            <th>شماره تلیفون ضامن   </th>
                            <th>کار ضامن</th>
                            <th>موقعیت کار ضامن </th>
                            <th>وضعیت </th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody id="residentsBody">
                        @foreach ($residents as $index => $resident)
                            <tr data-search="{{ $resident->name }} {{ $resident->room->room_number ?? '' }} {{ $resident->phone_number }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $resident->resident_code }}</td>
                                <td>{{ $resident->name }}</td>
                                <td>{{ $resident->father_name }}</td>
                                <td>{{ $resident->city_name }}</td>
                                <td>{{ $resident->phone_number }}</td>
                                <td>{{ $resident->room->room_number ?? 'بدون اتاق' }}</td>
                                <td>{{ $resident->occupation }}</td>
                                <td>{{ $resident->occupation_location }}</td>
                                <td>{{ $resident->work_phone }}</td>
                                <td>{{ $resident->guarantor_name }}</td>
                                <td>{{ $resident->guarantor_father_name }}</td>
                                <td>{{ $resident->guarantor_phone }}</td>
                                <td>{{ $resident->guarantor_occupation }}</td>
                                <td>{{ $resident->guarantor_occupation_location }}</td>
                                <td>{{ ucfirst($resident->status) }}</td>
                                <td class="text-center">
                                    <!-- Action buttons (e.g., Edit, Delete) can be added here -->
                                    <a href="" class="btn btn-sm
                                        btn-outline-primary">
                                        <i class="la la-edit"></i> ویرایش
                                    </a>

                        <tr></tr>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3 mb-3 d-flex justify-content-center">
                    {{ $residents->links() }}
                </div>
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

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
                            <th>ایمیل</th>
                            <th>نام کاربری</th>
                            <th>شماره تلیفون</th>
                            <th>نقش </th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr data-search="{{ $user->name }} {{ $user->email }} {{ $user->username }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->code }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->number }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td class="text-center">
                                    <!-- Add action buttons here if needed -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3 mb-3 d-flex justify-content-center">
                </div>
            </div>

        </div>

    </div>
</div>
    @endsection
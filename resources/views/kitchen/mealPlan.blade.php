@extends('layouts.generalLayouts')

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">

            <div class="page-banner mb-4" style="direction: rtl;">
                <div class="banner-icon">
                    <i class="la la-utensils text-white"></i>
                </div>

                <h5 class="mb-1 font-weight-bold">برنامه غذایی هفتگی</h5>

                <p class="mb-0 text-white-75">
                    جدول زمان‌بندی و وعده‌های غذایی روزانه
                </p>
            </div>


            <div class="card-soft p-4" style="direction: rtl;">


                <div class="table-responsive">

                    <table class="table table-bordered align-middle text-center mb-0">

                        <thead class="table-light">

                            <tr>

                                <th style="width:130px">
                                    روزهای هفته
                                </th>

                                <th>
                                    <i class="la la-coffee text-warning"></i>
                                    صبحانه
                                </th>

                                <th>
                                    <i class="la la-hamburger text-primary"></i>
                                    چاشت
                                </th>

                                <th>
                                    <i class="la la-drumstick-bite text-success"></i>
                                    شام
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                            @php
                                $days = [
                                    1 => 'شنبه',
                                    2 => 'یکشنبه',
                                    3 => 'دوشنبه',
                                    4 => 'سه‌شنبه',
                                    5 => 'چهارشنبه',
                                    6 => 'پنج‌شنبه',
                                    7 => 'جمعه',
                                ];

                            @endphp



                            @foreach($days as $dayKey => $dayName)

                                <tr>


                                    <th class="table-light fw-bold">

                                        {{ $dayName }}

                                    </th>



                                    {{-- Breakfast --}}

                                    <td>

                                        @if(isset($mealPlan[$dayKey]['breakfast']))

                                            <div class="p-2 bg-light rounded text-start">

                                                <div class="fw-bold text-dark">

                                                    {{ $mealPlan[$dayKey]['breakfast']->name }}

                                                </div>

                                            </div>

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif


                                    </td>




                                    {{-- Lunch --}}

                                    <td>


                                        @if(isset($mealPlan[$dayKey]['lunch']))

                                            <div class="p-2 bg-light rounded text-start">


                                                <div class="fw-bold text-dark">

                                                    {{ $mealPlan[$dayKey]['lunch']->name }}

                                                </div>


                                            </div>


                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>


                                        @endif


                                    </td>




                                    {{-- Dinner --}}

                                    <td>


                                        @if(isset($mealPlan[$dayKey]['dinner']))


                                            <div class="p-2 bg-light rounded text-start">


                                                <div class="fw-bold text-dark">

                                                    {{ $mealPlan[$dayKey]['dinner']->name }}

                                                </div>


                                            </div>


                                        @else


                                            <span class="text-muted">
                                                —
                                            </span>


                                        @endif


                                    </td>



                                </tr>


                            @endforeach


                        </tbody>


                    </table>


                </div>



                <div class="mt-4 text-end">

                    <a href="{{ route('resident.list') }}" class="btn btn-secondary">

                        <i class="la la-arrow-left"></i>

                        بازگشت به لیست

                    </a>

                </div>



            </div>


        </div>
    </div>


@endsection
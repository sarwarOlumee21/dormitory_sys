@extends('layouts.generalLayouts')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <!-- Page Banner -->
            <div class="page-banner mb-4" style="direction: rtl;">
                <div class="banner-icon">
                    <i class="la la-utensils text-white"></i>
                </div>
                <h5 class="mb-1 font-weight-bold">تنظیم برنامه غذایی هفتگی</h5>
                <p class="mb-0 text-white-75">انتخاب وعده‌های غذایی (صبحانه، چاشت، شام) برای هر روز هفته</p>
            </div>

            <!-- Meal Plan Form Card Container -->
            <div class="card-soft p-4" style="direction: rtl;">

                <!-- Meal Plan Form Start -->
                <form action="{{ route('registerMealPlan/store') }}" method="POST">
                    @csrf

                    <!-- Summary Header / Info -->
                    <input type="hidden" class="form-control" name="resident_id" value="">

                    <!-- Meal Plan Table Grid -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 120px;">روزهای هفته</th>
                                    <th scope="col" style="width: 29%;">
                                        <i class="la la-coffee text-warning me-1"></i> صبحانه
                                    </th>
                                    <th scope="col" style="width: 29%;">
                                        <i class="la la-hamburger text-primary me-1"></i> چاشت (ناهاری)
                                    </th>
                                    <th scope="col" style="width: 29%;">
                                        <i class="la la-drumstick-bite text-success me-1"></i> شب (شام)
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

                                @foreach($days as $day_key => $day_name)
                                    <tr>
                                        <th scope="row" class="table-light fw-bold text-center">
                                            {{ $day_name }}
                                        </th>

                                        <!-- Breakfast Select -->
                                        <td>
                                            <select name="meal_plan[{{ $day_key }}][breakfast]"
                                                class="form-select form-control text-start">
                                                <option value="">-- انتخاب کنید --</option>
                                                @foreach($breakfastMeals as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <!-- Lunch Select -->
                                        <td>
                                            <select name="meal_plan[{{ $day_key }}][lunch]"
                                                class="form-select form-control text-start">
                                                <option value="">-- انتخاب کنید --</option>
                                                @foreach($lunchMeals as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <!-- Dinner Select -->
                                        <td>
                                            <select name="meal_plan[{{ $day_key }}][dinner]"
                                                class="form-select form-control text-start">
                                                <option value="">-- انتخاب کنید --</option>
                                                @foreach($dinnerMeals as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Form Action Buttons -->
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <a href="" class="btn btn-secondary">
                            <i class="la la-arrow-left"></i> بازگشت به لیست
                        </a>

                        <button type="submit" class="btn btn-success px-4">
                            <i class="la la-save me-1"></i> ذخیره برنامه غذایی
                        </button>
                    </div>
                </form>
                <!-- Meal Plan Form End -->

            </div>
        </div>
    </div>
@endsection
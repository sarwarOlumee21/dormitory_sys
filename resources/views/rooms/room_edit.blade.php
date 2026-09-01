@extends('layouts.generalLayouts')

@section('content')

<div class="row justify-content-center dir-rtl">
    <div class="col-12 col-xl-8">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="top-banner mb-4">
            <div class="d-flex align-items-center">
                <div class="banner-icon ml-3">
                    <i class="la la-edit text-white"></i>
                </div>
                <div>
                    <h5 class="text-white mb-1 font-weight-bold">ویرایش اتاق</h5>
                    <p class="mb-0 banner-caption">تغییر ظرفیت و اطلاعات اتاق انتخابی</p>
                </div>
            </div>
        </div>

        <div class="card custom-card p-3">
            <form action="{{ route('rooms.update', ['id' => $room->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold mb-2">شماره اتاق</label>
                        <input type="text" name="room_number" class="form-control" value="{{ old('room_number', $room->room_number) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold mb-2">ظرفیت اتاق</label>
                        <input type="number" name="capacity" min="1" class="form-control" value="{{ old('capacity', $room->capacity) }}" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="font-weight-bold mb-2">یادداشت</label>
                        <textarea name="notes" class="form-control" rows="4" placeholder="یادداشت درباره اتاق...">{{ old('notes', $room->notes) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('rooms.list') }}" class="btn btn-outline-secondary px-4">
                        <i class="la la-arrow-right ml-1"></i> بازگشت
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="la la-save ml-1"></i> ذخیره تغییرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

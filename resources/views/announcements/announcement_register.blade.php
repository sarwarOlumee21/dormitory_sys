@extends('layouts.generalLayouts')
@section('content')
<div class="row"><div class="col-12"><div class="card shadow-sm border-0">
<div class="card-content collapse show"><div class="card-body">
<form method="POST" action="{{ route('announcements.store') }}">
@csrf
<div class="card border mb-0">
<div class="card-header bg-light py-1"><h6 class="mb-0 font-weight-bold"><i class="la la-bullhorn text-primary"></i> محتوای اعلان</h6></div>
<div class="card-body">
<div class="row">
<div class="col-md-8 form-group">
<label class="font-weight-bold font-small-3"><i class="la la-header text-primary"></i> عنوان</label>
<input type="text" name="title" class="form-control border-primary" value="{{ old('title') }}" placeholder="عنوان اعلان" required>
</div>
<div class="col-md-4 form-group">
<label class="font-weight-bold font-small-3"><i class="la la-tags text-primary"></i> دسته</label>
<select name="category" class="form-control border-primary">
<option>عمومی</option><option>قوانین</option><option>پرداخت</option><option>تعمیرات</option><option>رویداد</option>
</select>
</div>
<div class="col-md-4 form-group">
<label class="font-weight-bold font-small-3"><i class="la la-calendar text-primary"></i> تاریخ انتشار</label>
<input type="date" name="publish_date" class="form-control border-primary" value="{{ old('publish_date') }}">
</div>
<div class="col-md-4 form-group">
<label class="font-weight-bold font-small-3"><i class="la la-calendar-times-o text-primary"></i> تاریخ انقضا</label>
<input type="date" name="expire_date" class="form-control border-primary" value="{{ old('expire_date') }}">
</div>
<div class="col-md-4 form-group">
<label class="font-weight-bold font-small-3"><i class="la la-toggle-on text-primary"></i> وضعیت</label>
<select name="status" class="form-control border-primary"><option selected>فعال</option><option>پیش‌نویس</option><option>منقضی</option></select>
</div>
<div class="col-12 form-group mb-0">
<label class="font-weight-bold font-small-3"><i class="la la-align-right text-primary"></i> متن اعلان</label>
<textarea name="content" class="form-control border-primary" rows="6" placeholder="متن کامل اعلان برای ساکنین..." required>{{ old('content') }}</textarea>
</div>
</div>
</div>
<div class="card-footer bg-light text-right">
<button type="reset" class="btn btn-warning mr-1"><i class="ft-x"></i> لغو</button>
<button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> انتشار اعلان</button>
</div>
</div>
</form>
</div></div></div></div></div>
@endsection

@extends('layouts.generalLayouts')
@section('content')
<!-- <div class="row"><div class="col-12"><div class="card shadow-sm border-0">
<div class="card-content collapse show"><div class="card-body">
<div class="text-left mb-3"><a href="{{ route('announcements.register') }}" class="btn btn-primary btn-sm"><i class="la la-plus"></i> اعلان جدید</a></div>
@foreach([
    ['title'=>'پرداخت اجاره ماه حمل','cat'=>'پرداخت','date'=>'1404/03/01','status'=>'فعال','text'=>'لطفاً تا تاریخ ۱۵ حمل اجاره خود را پرداخت کنید.'],
    ['title'=>'ساعت ورود مهمان','cat'=>'قوانین','date'=>'1404/02/20','status'=>'فعال','text'=>'ورود مهمان فقط بین ساعت ۸ صبح تا ۸ شب مجاز است.'],
    ['title'=>'تعمیرات اتاق D-01','cat'=>'تعمیرات','date'=>'1404/02/15','status'=>'فعال','text'=>'اتاق D-01 تا اطلاع ثانوی بسته است.'],
] as $i => $a)
<div class="card border mb-2">
<div class="card-body py-2">
<div class="d-flex justify-content-between align-items-start flex-wrap">
<div class="flex-grow-1">
<h6 class="font-weight-bold mb-1">{{ $a['title'] }}</h6>
<p class="text-muted font-small-3 mb-1">{{ $a['text'] }}</p>
<small class="text-muted"><i class="la la-calendar"></i> {{ $a['date'] }}</small>
</div>
<div class="text-left mt-1 mt-md-0">
<span class="badge badge-info">{{ $a['cat'] }}</span>
<span class="badge badge-success">{{ $a['status'] }}</span>
<div class="btn-group btn-group-sm mt-1">
<button class="btn btn-outline-primary"><i class="la la-eye"></i></button>
<button class="btn btn-outline-info"><i class="la la-edit"></i></button>
<button class="btn btn-outline-danger"><i class="la la-trash"></i></button>
</div>
</div>
</div>
</div>
</div>
@endforeach
</div></div></div></div></div> -->
<div>
    <h1>for future</h1>
</div>
@endsection

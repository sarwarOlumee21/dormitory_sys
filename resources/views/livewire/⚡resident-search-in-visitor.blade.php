<?php

use Livewire\Component;
use App\Models\Resident;
use App\Models\Room;

new class extends Component {
    public string $search = '';
    public ?int $resident_id = null;
    public bool $showResidents = false;
    public $rooms = [];

    public function mount()
    {
        $this->rooms = Room::all();
    }

    public function updatedSearch($value)
    {
        $this->resident_id = null;
        $this->showResidents = strlen(trim($value)) >= 1;
    }
        public function getResidentsProperty()
    {
        if (strlen(trim($this->search)) < 1) {
            return collect();
        }

        $keyword = '%' . trim($this->search) . '%';

        return Resident::query()
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', $keyword)
                    ->orwhere('resident_code', 'like', $keyword);
            })
            ->orderBy('name')
            ->limit(10)
            ->get();
    }
        public function selectResident($id)
    {
        $resident = Resident::find($id);
        if (!$resident) {
            return;
        }
        if($resident->room_id == null){
            $this->emit('noRoomAssigned');
        }

        $this->resident_id = $resident->id;
        $this->search = $resident->name;
        $this->showResidents = false;
    }

};
?>

<div>
    {{-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger --}}
    <form action="{{ route('visitors.store') }}" method="POST">
        @csrf
        <div class="card custom-form-card">
            <div class="card-header">
                <i class="la la-id-badge"></i>
                <span>مشخصات و اطلاعات ورود مهمان</span>
            </div>
            <div class="card-body py-4">
                <div class="row">

                    <div class="col-md-6 form-group mb-4">
                        <label class="flabel">کد و نام شخص</label>
                        <div class="position-relative">

                            <label class="flabel">
                                کد و نام شخص
                            </label>

                            <input type="text" class="finput w-100" wire:model.live.debounce.300ms="search"
                                placeholder="نام شخص را وارد کنید...">

                            <input type="hidden" name="resident_id" value="{{ $resident_id }}">

                            @if($search != '' && $showResidents && $this->residents->count())

                                <div class="list-group position-absolute w-100 shadow bg-white"
                                    style="z-index:1000; max-height:250px; overflow:auto;">

                                    @foreach($this->residents as $resident)

                                        <button type="button" class="list-group-item list-group-item-action"
                                            wire:click="selectResident({{ $resident->id }})">

                                            <strong>#{{ $resident->id }}</strong>
                                            -
                                            {{ $resident->name }}
                                            -
                                            {{ $resident->resident_code }}

                                        </button>

                                    @endforeach

                                </div>

                            @elseif($showResidents && strlen($search) >= 1)

                                <div class="list-group position-absolute w-100 shadow bg-white" style="z-index:1000;">

                                    <div class="list-group-item text-danger">
                                        نتیجه‌ای یافت نشد.
                                    </div>

                                </div>

                            @endif

                        </div>
                    </div>

                    <div class="col-md-6 form-group mb-4">
                        <label class="flabel"><i class="la la-user-plus text-primary"></i> نام کامل مهمان</label>
                        <input type="text" class="form-control" name="guest_name"
                            placeholder="نام و نام خانوادگی مهمان">
                    </div>

                    <div class="col-md-6 form-group mb-4">
                        <label class="flabel"><i class="la la-phone text-primary"></i> شماره تماس</label>
                        <input type="text" class="form-control text-right" name="guest_phone" dir="ltr"
                            placeholder="07xxxxxxxx">
                    </div>

                    <div class="col-md-6 form-group mb-4">
                        <label class="flabel"><i class="la la-id-card text-primary"></i> تذکره / کارت هویت</label>
                        <input type="text" class="form-control" name="guest_id_number"
                            placeholder="شماره تذکره یا مدرک شناسایی">
                    </div>

                    <div class="col-md-4 form-group mb-4">
                        <label class="flabel"><i class="la la-calendar text-primary"></i> تاریخ و ساعت ورود</label>
                        <input type="datetime-local" class="form-control" name="check_in_at">
                    </div>

                    <div class="col-md-4 form-group mb-4">
                        <label class="flabel"><i class="la la-calendar-check-o text-primary"></i> تاریخ خروج پیش‌بینی
                            شده</label>
                        <input type="datetime-local" class="form-control" name="check_out_at">
                    </div>

                    <div class="col-md-4 form-group mb-4">
                        <label class="flabel"><i class="la la-toggle-on text-primary"></i> انتخاب اتاق</label>
                        <select class="form-control" name="room_number">
                            <option selected disabled>انتخاب اتاق</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 form-group mb-4">
                        <label class="flabel"><i class="la la-sticky-note text-primary"></i> هدف از بازدید</label>
                        <input type="text" class="form-control" name="purpose"
                            placeholder="دیدار خانوادگی، تحویل وسایل، پروژه‌های درسی و غیره...">
                    </div>

                </div>

                {{-- دکمه‌های عملیاتی پایین فرم کاملاً ست‌شده و تمیز --}}
                <div class="d-flex align-items-center justify-content-end pt-3 mt-2 card-footer-maintain">
                    <button type="reset" class="btn btn-outline-secondary px-4 ml-2 btn-maintain-outline">
                        <i class="la la-close"></i> لغو و پاکسازی
                    </button>
                    <button type="submit" class="btn btn-primary px-4 btn-maintain-primary">
                        <i class="la la-check-square"></i> ثبت اطلاعات مهمان
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
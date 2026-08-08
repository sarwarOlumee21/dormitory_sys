<?php

use Livewire\Component;
use App\Models\Resident;

new class extends Component {
    public string $search = '';
    public ?int $resident_id = null;
    public bool $showResidents = false;

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

        $this->resident_id = $resident->id;
        $this->search = $resident->name;
        $this->showResidents = false;
    }
};
?>

<div>
    <form method="post" action="{{ route('contracts.store') }}">
        @csrf

        <!-- 🔵 ONE BIG CARD -->
        <div class="card custom-form-card">

            <div class="card-header">
                <i class="la la-file-text"></i>
                <span>فرم قرارداد</span>
            </div>

            <div class="card-body">
                <!-- جزئیات قرارداد -->
                <div class="row">

                    <div class="col-lg-6 mb-3">
                        <!-- <label class="flabel">تاریخ پایان قرارداد</label>
                                        <input type="date" class="finput w-100"> -->
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
                    <div class="col-lg-6 mb-3">
                        <label class="flabel">تاریخ شروع قرارداد</label>
                        <input type="date" name="contract_date" class="finput w-100">
                    </div>


                    <div class="col-lg-6 mb-3">
                        <label class="flabel">مبلغ قرارداد (افغانی)</label>
                        <input type="number" name="contract_amount" class="finput w-100" placeholder="45000">
                    </div>

                    <div class="col-lg-6 mb-3">
                        <label class="flabel">وضعیت قرارداد</label>
                        <select class="finput w-100" name="contract_status">
                            <option value="فعال">فعال</option>
                            <option value="تمدید نشده">تمدید نشده</option>
                            <option value="خاتمه یافته">خاتمه یافته</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="flabel">توضیحات</label>
                        <textarea class="finput w-100" placeholder="توضیحات" name="notes"></textarea>
                    </div>
                </div>

                <hr>

                <!-- قوانین -->
                @if(!empty($storedRules))
                    <div class="p-3 bg-light rounded">
                        <h6>قوانین قرارداد</h6>
                        <div style="white-space: pre-wrap;">
                            {!! nl2br(e($storedRules)) !!}
                        </div>
                    </div>
                @endif

            </div>

            <!-- دکمه‌ها -->
            <div class="card-body d-flex justify-content-between align-items-center"
                style="background:#f8fafc; border-top:1px solid #e2e8f0;">
                <small class="text-muted">قبل از ثبت، اطلاعات را مرور کنید</small>

                <div>
                    <button type="reset" class="btn btn-outline-secondary">لغو</button>
                    <button type="submit" class="btn btn-primary">
                        ثبت قرارداد
                    </button>
                </div>
            </div>

        </div>

    </form>
</div>
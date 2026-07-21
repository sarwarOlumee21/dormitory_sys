<div>
    <div class="filter-card p-3 mb-4">
        <div class="row gx-2 gy-2 align-items-end">
            <div class="col-md-10">
                <label class="form-label fw-bold" style="direction:rtl;">جستجو</label>
                <input type="text" class="form-control border-primary" placeholder="نام، کد، اتاق، تلفن..." wire:model.live.debounce.300ms="search">
            </div>
            <div class="col-md-2">
                <span class="text-muted small" style="direction:rtl;">جستجو به‌صورت زنده انجام می‌شود</span>
            </div>
        </div>
    </div>

    @if ($residents->isEmpty())
        <div class="alert alert-info mx-3">هیچ ساکنی با این جست‌وجو یافت نشد.</div>
    @else
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
                <tbody>
                    @foreach ($residents as $index => $resident)
                        <tr>
                            <td>{{ $residents->firstItem() + $loop->index }}</td>
                            <td>{{ $resident->resident_code ?? '-' }}</td>
                            <td>{{ $resident->name ?? '-' }}</td>
                            <td>{{ $resident->phone_number ?? '-' }}</td>
                            <td>{{ $resident->room?->room_number ?? 'بدون اتاق' }}</td>
                            <td>{{ $resident->status ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('resident.list.details', ['id' => $resident->id]) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="la la-eye"></i> جزئیات
                                </a>
                                <a href="{{ route('resident.list.edit', ['id' => $resident->id]) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="la la-edit"></i> ویرایش
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3 mb-3 d-flex justify-content-center">
            {{ $residents->links() }}
        </div>
    @endif
</div>
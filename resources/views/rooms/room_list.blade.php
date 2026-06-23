@extends('layouts.generalLayouts')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-xl-11">

        <div class="top-banner d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="banner-icon">
                    <i class="la la-server text-white" style="font-size:22px;"></i>
                </div>
                <h5 class="text-white mb-1 font-weight-bold" style="direction:rtl;">مدیریت و لیست اتاق‌ها</h5>
                <p class="mb-0" style="color:rgba(255,255,255,.75);font-size:13px;direction:rtl;">لیست وضعیت، ظرفیت و ویرایش اتاق‌های خوابگاه اندیشه</p>
            </div>
            <div>
                <a href="{{ route('rooms.register') }}" class="btn btn-light btn-sm px-4 py-2 font-weight-bold" style="border-radius:10px; color:#1a56db;">
                    <i class="la la-plus-circle font-medium-2"></i> ثبت اتاق جدید
                </a>
            </div>
        </div>

        <div class="form-outer">
            
            <div class="row mb-4" style="direction:rtl;">
                <div class="col-md-4 col-6 mb-2 mb-md-0">
                    <div class="p-3" style="background:rgba(26,86,219,0.06); border-radius:12px; border: 1px solid rgba(26,86,219,0.12);">
                        <div class="d-flex align-items-center" style="gap: 12px;">
                            <span class="p-2" style="background:#1a56db; border-radius:10px; color:white; margin-left: 12px; display: inline-flex;">
                                <i class="la la-home font-medium-3"></i>
                            </span>
                            <div>
                                <h3 class="mb-0 font-weight-bold" id="statTotal" style="color:#1a56db; line-height: 1.2;">{{ $count }}</h3>
                                <small class="text-muted font-weight-bold">کل اتاق‌ها</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6 mb-2 mb-md-0">
                    <div class="p-3" style="background:rgba(40,167,69,0.06); border-radius:12px; border: 1px solid rgba(40,167,69,0.12);">
                        <div class="d-flex align-items-center" style="gap: 12px;">
                            <span class="p-2" style="background:#28a745; border-radius:10px; color:white; margin-left: 12px; display: inline-flex;">
                                <i class="la la-check-circle font-medium-3"></i>
                            </span>
                            <div>
                                <h3 class="mb-0 font-weight-bold" id="statActive" style="color:#28a745; line-height: 1.2;">{{ $activeRooms }}</h3>
                                <small class="text-muted font-weight-bold">اتاق‌های فعال</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="p-3" style="background:rgba(253,126,20,0.06); border-radius:12px; border: 1px solid rgba(253,126,20,0.12);">
                        <div class="d-flex align-items-center" style="gap: 12px;">
                            <span class="p-2" style="background:#fd7e14; border-radius:10px; color:white; margin-left: 12px; display: inline-flex;">
                                <i class="la la-exclamation-circle font-medium-3"></i>
                            </span>
                            <div>
                                <h3 class="mb-0 font-weight-bold" id="statOther" style="color:#fd7e14; line-height: 1.2;">{{ $count - $activeRooms }}</h3>
                                <small class="text-muted font-weight-bold">پر </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 p-3" style="background:#f8fafc; border-radius:12px; border:1px solid #e2e8f0;">
                <div class="row align-items-end" style="direction:rtl;">
                    <div class="col-md-4 form-group mb-2 mb-md-0">
                        <label class="flabel"><i class="la la-search" style="margin-left: 6px;"></i> جستجو</label>
                        <input type="text" id="filterSearch" class="finput" placeholder="شماره یا نوع اتاق...">
                    </div>
                    <div class="col-md-3 form-group mb-2 mb-md-0">
                        <label class="flabel"><i class="la la-th-large" style="margin-left: 6px;"></i> نوع اتاق</label>
                        <select id="filterType" class="finput">
                            <option value="">همه</option>
                            <option value="تک‌نفره">تک‌نفره</option>
                            <option value="دو‌نفره">دو‌نفره</option>
                            <option value="گروهی">گروهی</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-2 mb-md-0">
                        <label class="flabel"><i class="la la-toggle-on" style="margin-left: 6px;"></i> وضعیت</label>
                        <select id="filterStatus" class="finput">
                            <option value="">همه</option>
                            <option value="فعال">فعال</option>
                            <option value="پر">پر</option>
                            <option value="در حال تعمیر">در حال تعمیر</option>
                            <option value="غیرفعال">غیرفعال</option>
                        </select>
                    </div>
                    <div class="col-md-2 form-group mb-0">
                        <button type="button" class="btn btn-primary btn-block btn-sm py-2 font-weight-bold" id="btnFilter" style="background:#1a56db; border:none; border-radius:10px; height: 42px;">
                            <i class="la la-filter" style="margin-left: 4px;"></i> فیلتر آنی
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive" style="border: 1px solid #e2e8f0; border-radius:12px; overflow:hidden;">
                <table class="table table-hover mb-0" id="roomsTable" style="direction:rtl; text-align:right;">
                    <thead style="background:#f1f5f9; border-bottom:2px solid #e2e8f0;">
                        <tr>
                            <th class="border-0 font-weight-bold" style="color:#475569;">#</th>
                            <th class="border-0 font-weight-bold" style="color:#475569;">شماره اتاق</th>
                            <th class="border-0 font-weight-bold" style="color:#475569;">ظرفیت</th>
                            <th class="border-0 font-weight-bold" style="color:#475569;">نوع اتاق</th>
                            <th class="border-0 font-weight-bold" style="color:#475569;">وضعیت</th>
                            <th class="border-0 font-weight-bold text-center" style="color:#475569;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody id="roomsBody">
                        @foreach ($rooms as $room)
                        <tr data-number="{{ $room->room_number }}" data-capacity="{{ $room->capacity }}" data-type="{{ $room->room_type }}" data-status="{{ $room->status }}">
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle"><span class="badge badge-pill badge-light border px-3 py-1 font-weight-bold text-primary">{{ $room->room_number }}</span></td>
                            <td class="align-middle"><span class="text-dark font-weight-bold">{{ $room->capacity }} نفر</span></td>
                            <td class="align-middle text-muted">{{ $room->room_type }}</td>
                            <td class="align-middle"><span class="badge badge-success px-2 py-1" style="border-radius:6px;">{{ ucfirst($room->status) }}</span></td>
                            <td class="text-center align-middle">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-link text-primary p-1 btn-demo-view" title="مشاهده"><i class="la la-eye font-medium-3"></i></button>
                                    <button type="button" class="btn btn-link text-info p-1" title="ویرایش"><i class="la la-edit font-medium-3"></i></button>
                                    <button type="button" class="btn btn-link text-danger p-1 btn-delete" title="حذف"><i class="la la-trash font-medium-3"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
(function () {
    const rows = Array.from(document.querySelectorAll('#roomsBody tr[data-number]'));
    const totalRows = rows.length;

    function applyFilter() {
        const q = (document.getElementById('filterSearch').value || '').trim().toLowerCase();
        const type = document.getElementById('filterType').value;
        const status = document.getElementById('filterStatus').value;
        let visible = 0, active = 0, other = 0;

        rows.forEach(function (row) {
            const matchSearch = !q || [
                row.dataset.number,
                row.dataset.type,
                row.dataset.capacity
            ].some(function (v) { return (v || '').toLowerCase().indexOf(q) !== -1; });

            const matchType = !type || row.dataset.type === type;
            const matchStatus = !status || row.dataset.status === status;
            const show = matchSearch && matchType && matchStatus;

            row.style.display = show ? '' : 'none';
            if (show) {
                visible++;
                row.cells[0].textContent = visible;
                if (row.dataset.status === 'فعال') active++;
                else other++;
            }
        });

        document.getElementById('statTotal').textContent = visible.toLocaleString('fa-IR');
        document.getElementById('statActive').textContent = active.toLocaleString('fa-IR');
        document.getElementById('statOther').textContent = other.toLocaleString('fa-IR');
        document.getElementById('tableInfo').textContent =
            'نمایش ' + visible.toLocaleString('fa-IR') + ' اتاق از ' + totalRows.toLocaleString('fa-IR');

        let emptyRow = document.getElementById('emptyFilterRow');
        if (visible === 0) {
            if (!emptyRow) {
                emptyRow = document.createElement('tr');
                emptyRow.id = 'emptyFilterRow';
                emptyRow.innerHTML = '<td colspan="6" class="text-center text-muted py-4">' +
                    '<i class="la la-inbox font-large-2 d-block mb-1"></i>اتاقی با این فیلتر یافت نشد</td>';
                document.getElementById('roomsBody').appendChild(emptyRow);
            }
            emptyRow.style.display = '';
        } else if (emptyRow) {
            emptyRow.style.display = 'none';
        }
    }

    document.getElementById('btnFilter').addEventListener('click', applyFilter);
    document.getElementById('filterSearch').addEventListener('keyup', function (e) {
        if (e.key === 'Enter') applyFilter();
    });
    ['filterType', 'filterStatus'].forEach(function (id) {
        document.getElementById(id).addEventListener('change', applyFilter);
    });

    document.querySelectorAll('.btn-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (confirm('آیا از حذف این اتاق مطمئن هستید؟')) {
                alert('حذف اتاق — پس از اتصال به سرور فعال می‌شود.');
            }
        });
    });
})();
</script>

@endsection
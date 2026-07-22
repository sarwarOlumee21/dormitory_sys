<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

new class extends Component {
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';


    public function updatingSearch(): void
    {
        $this->resetPage();
    }


    public function getUsersProperty()
    {
        $query = User::query()->orderBy('id', 'desc');

        if (!empty(trim($this->search))) {

            $keyword = '%' . trim($this->search) . '%';

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', $keyword)
                    ->orWhere('email', 'like', $keyword)
                    ->orWhere('username', 'like', $keyword);
            });
        }

        return $query->paginate(10);
    }
};
?>

<div>
    <div class="filter-card p-3 mb-4">
        <div class="row gx-2 gy-2 align-items-end">
            <div class="col-md-10">
                <label class="form-label fw-bold" style="direction:rtl;">جستجو</label>
                <input type="text" wire:model.live="search" class="form-control border-primary"
                    placeholder="نام، ایمیل، نام کاربری...">
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
                @foreach ($this->users as $index => $user)
                    <tr data-search="{{ $user->name }} {{ $user->email }} {{ $user->username }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->code }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->number }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td class="text-center">
                            <a href="{{ route('users.userEdit', ['id' => $user->id]) }}"
                                class="btn btn-sm btn-outline-primary">
                                <i class="la la-edit"></i> ویرایش
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3 mb-3 d-flex justify-content-center">
        </div>
    </div>
</div>
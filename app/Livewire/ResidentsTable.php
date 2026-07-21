<?php

namespace App\Livewire;

use App\Models\Resident;
use Livewire\Component;
use Livewire\WithPagination;

class ResidentsTable extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Resident::query()->with('room');

        if (! empty(trim($this->search))) {
            $keyword = '%' . trim($this->search) . '%';

            $query->where(function ($q) use ($keyword): void {
                $q->where('name', 'like', $keyword)
                    ->orWhere('resident_code', 'like', $keyword)
                    ->orWhere('phone_number', 'like', $keyword)
                    ->orWhereHas('room', function ($roomQuery) use ($keyword): void {
                        $roomQuery->where('room_number', 'like', $keyword);
                    });
            });
        }

        $residents = $query->paginate(10);

        return view('livewire.residents-table', [
            'residents' => $residents,
        ]);
    }
}
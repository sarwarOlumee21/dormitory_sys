<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractRegister extends Model
{
    protected $table = 'contracts';

    protected $fillable = [
        'room_id',
        'resident_id',
        'contract_date',
        'contract_amount',
        'contract_status',
        'notes',
        // Add other fields as necessary
    ];
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }
}

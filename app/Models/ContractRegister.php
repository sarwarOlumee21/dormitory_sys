<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractRegister extends Model
{
    protected $table = 'contracts';

    protected $fillable = [
        'resident_id',
        'contract_date',
        'contract_amount',
        'contract_status',
        'payment_mounth',
        'payment_years',
        'notes',
        // Add other fields as necessary
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }
}

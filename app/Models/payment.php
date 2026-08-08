<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'amount',
        'residents_id',
        'payment_date',
        'notes',
        // Add other fields as necessary
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'residents_id');
    }
}

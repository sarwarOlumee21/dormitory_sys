<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitors extends Model
{
    protected $table = 'visitors';
    protected $fillable = [
        'guest_name',
        'resident_id',
        'guest_phone',
        'guest_id_number',
        'check_in_at',
        'check_out_at',
        'room_number',
        'purpose',
    ];
    
public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_number');
    }
}

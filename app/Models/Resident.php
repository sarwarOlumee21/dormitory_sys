<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $fillable = [
        'resident_code',
        'name',
        'father_name',
        'phone_number',
        'city_name',
        'room_id',
        'occupation',
        'work_phone',
        'occupation_location',
        'guarantor_name',
        'guarantor_father_name',
        'guarantor_phone',
        'guarantor_occupation',
        'guarantor_occupation_location',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_code',
        'name',
        'father_name',
        'phone_number',
        'city_name',
        'occupation',
        'work_phone',
        'occupation_location',
        'guarantor_name',
        'guarantor_father_name',
        'guarantor_phone',
        'guarantor_occupation',
        'guarantor_occupation_location',
        'status',
        'room_id',
        'name',
        'father_name',
        'phone_number',
        'city_name',
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

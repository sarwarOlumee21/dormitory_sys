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
        'resident_image_url',
        'id_card_image_url',
        'guarantor_image_url',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function contracts()
    {
        return $this->hasMany(ContractRegister::class, 'resident_id');
    }

    public function latestContract()
    {
        return $this->hasOne(ContractRegister::class, 'resident_id')->latestOfMany();
    }
    public function payments()
{
    return $this->hasMany(Payment::class, 'residents_id');
}
}

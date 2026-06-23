<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'capacity',
        'room_type',
        'notes',
        'status',
        // Add other fields as necessary
    ];
    public function residents()
    {
        return $this->hasMany(Resident::class, 'room_id');
    }
}

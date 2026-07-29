<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $fillable = [
        'resident_id',
        'room_id',
        'priority',
        'description',
        'status',
        'is_active',
        'request_types_id',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function requestType()
    {
        return $this->belongsTo(RequestType::class, 'request_types_id');
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

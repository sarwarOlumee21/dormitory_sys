<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'priority',
        'description',
        'admin_comment',
        'status',
        'is_active',
        'request_types_id',
        'notification_read_at',
    ];

    protected function casts(): array
    {
        return [
            'notification_read_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

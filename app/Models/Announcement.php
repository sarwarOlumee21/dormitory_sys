<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'category',
        'publish_date',
        'expire_date',
        'status',
        'content',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'expire_date' => 'date',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealSchedule extends Model
{
    protected $table = 'meal_schedules';
    protected $fillable = [
        'day_of_week',
        'meals_id',
        'status',        // Add other fields as necessary
    ];

    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meals_id');
    }
}

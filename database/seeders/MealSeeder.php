<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;

class MealSeeder extends Seeder
{
    public function run(): void
    {
        $meals = [

            // Breakfast
            ['name' => 'تخم مرغ سرخ شده', 'meal_type' => 'breakfast'],
            ['name' => 'پنیر و نان', 'meal_type' => 'breakfast'],
            ['name' => 'شیر و کورن فلکس', 'meal_type' => 'breakfast'],
            ['name' => 'املت', 'meal_type' => 'breakfast'],
            ['name' => 'حلوا و نان', 'meal_type' => 'breakfast'],
            ['name' => 'مربا و کره', 'meal_type' => 'breakfast'],
            ['name' => 'چای و کیک', 'meal_type' => 'breakfast'],
            ['name' => 'لوبیا', 'meal_type' => 'breakfast'],

            // Lunch
            ['name' => 'قابلی پلو', 'meal_type' => 'lunch'],
            ['name' => 'کباب', 'meal_type' => 'lunch'],
            ['name' => 'مرغ بریان', 'meal_type' => 'lunch'],
            ['name' => 'ماکارونی', 'meal_type' => 'lunch'],
            ['name' => 'قورمه سبزی', 'meal_type' => 'lunch'],
            ['name' => 'پلو و گوشت', 'meal_type' => 'lunch'],
            ['name' => 'برنج و لوبیا', 'meal_type' => 'lunch'],
            ['name' => 'منتو', 'meal_type' => 'lunch'],
            ['name' => 'آشک', 'meal_type' => 'lunch'],

            // Dinner
            ['name' => 'سوپ مرغ', 'meal_type' => 'dinner'],
            ['name' => 'آش', 'meal_type' => 'dinner'],
            ['name' => 'عدسی', 'meal_type' => 'dinner'],
            ['name' => 'ساندویچ مرغ', 'meal_type' => 'dinner'],
            ['name' => 'برنج و سبزیجات', 'meal_type' => 'dinner'],
            ['name' => 'خوراک لوبیا', 'meal_type' => 'dinner'],
            ['name' => 'نان و پنیر', 'meal_type' => 'dinner'],
            ['name' => 'فرنی', 'meal_type' => 'dinner'],
        ];

        foreach ($meals as $meal) {
            Meal::create($meal);
        }
    }
}
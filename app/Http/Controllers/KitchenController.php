<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\MealSchedule;
use Illuminate\Support\Facades\DB;


class KitchenController extends Controller
{
    public function mealplan()
    {
            $meal_schedules = MealSchedule::with('meal')
        ->where('status', 'active')
        ->get();


    $mealPlan = [];

    foreach ($meal_schedules as $schedule) {
        $day = $schedule->day_of_week;
        $type = $schedule->meal->meal_type;
        $mealPlan[$day][$type] = $schedule->meal;
    }
        return view('kitchen/mealplan', compact('mealPlan'));
    }
    public function registerMealPlan()
    {
          $breakfastMeals = Meal::where('meal_type', 'breakfast')->get();
        $lunchMeals = Meal::where('meal_type', 'lunch')->get();
        $dinnerMeals = Meal::where('meal_type', 'dinner')->get(); 
        return view('kitchen/registerMealPlan', compact('breakfastMeals', 'lunchMeals', 'dinnerMeals'));
    }
public function mealFoods()
{
    return view('kitchen.mealFoods');
}
    public function storeMealFood(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meal_type' => 'nullable|in:breakfast,lunch,dinner',
        ]);


        // Create a new meal food record in the database
        Meal::create($validatedData);

        // Redirect back with a success message
        return redirect()->route('mealFoods')->with('success', 'غذا با موفقیت ثبت شد.');
    }


public function registerMealPlans(Request $request)
{
    $validatedData = $request->validate([
        'meal_plan' => 'required|array',
        'meal_plan.*.breakfast' => 'nullable|exists:meals,id',
        'meal_plan.*.lunch' => 'nullable|exists:meals,id',
        'meal_plan.*.dinner' => 'nullable|exists:meals,id',
    ]);


    DB::transaction(function () use ($validatedData) {

        foreach ($validatedData['meal_plan'] as $day => $meals) {


            // غیر فعال کردن برنامه قبلی همان روز
            MealSchedule::where('day_of_week', $day)
                ->where('status', 'active')
                ->update([
                    'status' => 'inactive'
                ]);


            // ثبت برنامه جدید
            foreach ($meals as $meal_id) {

                if ($meal_id) {

                    MealSchedule::create([
                        'day_of_week' => $day,
                        'meals_id' => $meal_id,
                        'status' => 'active',
                    ]);

                }

            }

        }

    });


    return redirect()
        ->route('registerMealPlan')
        ->with('success', 'برنامه غذایی با موفقیت ثبت شد.');
}
}

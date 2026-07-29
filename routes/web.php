<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\KitchenController;


Route::get('/', [ResidentController::class, 'index'])->name('home')->middleware(['auth', 'role:admin,manager,staff,user']);
Route::prefix('resident')->name('resident.')->group(function () {
    Route::get('/resident_register', [ResidentController::class, 'ResidentRegister'])->name('register')->middleware(['auth', 'role:admin,manager,staff']);
    Route::get('/resident_list', [ResidentController::class, 'ResidentList'])->name('list')->middleware(['auth', 'role:admin,manager,staff']);
    Route::get('/resident_list/{id}', [ResidentController::class, 'ResidentListDetails'])->name('list.details')->middleware(['auth', 'role:admin,manager,staff']);
    Route::get('/resident_list/{id}/edit', [ResidentController::class, 'ResidentListEdit'])->name('list.edit')->middleware(['auth', 'role:admin,manager,staff']);
    Route::post('/resident_list/{id}/update', [ResidentController::class, 'update'])->name('update')->middleware(['auth', 'role:admin,manager,staff']);
});
Route::prefix('rooms')->name('rooms.')->group(function () {
    Route::get('/room_register', [RoomController::class, 'RoomRegister'])->name('register')->middleware(['auth', 'role:admin,manager,staff']);
    Route::get('/room_list', [RoomController::class, 'RoomList'])->name('list')->middleware(['auth', 'role:admin,manager,staff']);
});
Route::prefix('contracts')->name('contracts.')->group(function () {
    Route::get('/contracts_edit/{id}', [ContractsController::class, 'ContractsEdit'])->name('edit')->middleware(['auth', 'role:admin,manager,staff']);
    Route::get('/contracts_register', [ContractsController::class, 'ContractsRegister'])->name('register')->middleware(['auth', 'role:admin,manager,staff']);
    Route::get('/contracts_rules', [ContractsController::class, 'ContractsRules'])->name('rules')->middleware(['auth', 'role:admin,manager,staff']);
    Route::post('/rules/save', [ContractsController::class, 'storeRules'])->name('rules.save')->middleware(['auth', 'role:admin,manager,staff']);
    Route::get('/contracts_list', [ContractsController::class, 'ContractsList'])->name('list')->middleware(['auth', 'role:admin,manager,staff']);
    Route::post('/store', [ContractsController::class, 'contractStore'])->name('store')->middleware(['auth', 'role:admin,manager,staff']);
    Route::post('/payment/store', [ContractsController::class, 'storePayment'])->name('payment.store')->middleware(['auth', 'role:admin,manager,staff']);
    Route::get('/{id}/show', [ContractsController::class, 'showContract'])->name('show')->middleware(['auth', 'role:admin,manager,staff']);
    Route::post('/{id}/toggle', [ContractsController::class, 'toggleStatus'])->name('toggle')->middleware(['auth', 'role:admin,manager,staff']);
    Route::put('/{id}', [ContractsController::class, 'update'])->name('update')->middleware(['auth', 'role:admin,manager,staff']);
});
Route::prefix('visitors')->name('visitors.')->group(function () {
    Route::get('/register', [VisitorController::class, 'register'])->name('register')->middleware(['auth', 'role:admin,manager,staff']);
    Route::get('/list', [VisitorController::class, 'list'])->name('list')->middleware(['auth', 'role:admin,manager,staff']);
    Route::post('/store', [VisitorController::class, 'store'])->name('store')->middleware(['auth', 'role:admin,manager,staff']);
});
Route::prefix('maintenance')->name('maintenance.')->group(function () {
Route::get('/request', [MaintenanceController::class, 'maintenanceRequest'])
    ->name('request')
    ->middleware(['auth', 'role:admin,manager,staff,user']);
    Route::get('/requestType', [MaintenanceController::class, 'requestType'])->name('requestType')->middleware(['auth', 'role:admin,manager,staff,user']);
    Route::post('/requestType/save', [MaintenanceController::class, 'saveRequestType'])->name('requestType.save')->middleware(['auth', 'role:admin,manager,staff,user']);
    Route::post('/request/save', [MaintenanceController::class, 'saveRequest'])->name('request.save')->middleware(['auth', 'role:admin,manager,staff,user']);
    Route::get('/list', [MaintenanceController::class, 'list'])->name('list')->middleware(['auth', 'role:admin,manager,staff']);
    // Route::post('/request/save', [MaintenanceController::class, 'saveRequest'])->name('request.save')->middleware(['auth', 'role:admin,manager,staff,user']);
});
Route::prefix('announcements')->name('announcements.')->group(function () {
    Route::get('/register', [AnnouncementController::class, 'register'])->name('register')->middleware(['auth', 'role:admin,manager,staff']);
    Route::get('/list', [AnnouncementController::class, 'list'])->name('list')->middleware(['auth', 'role:admin,manager,staff']);
});
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index')->middleware(['auth', 'role:admin,manager,staff']);
Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('/resident/store', [ResidentController::class, 'store'])->name('resident.store')->middleware(['auth', 'role:admin,manager,staff']);
Route::post('/rooms/store', [RoomController::class, 'store'])->name('rooms.store')->middleware(['auth', 'role:admin,manager,staff']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::post('/loginform', [AuthenticationController::class, 'login'])->name('loginform');
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/userRegister', [UserController::class, 'userRegister'])->name('userRegister')->middleware(['auth', 'role:admin,manager,staff']);
    Route::post('/store', [UserController::class, 'userStore'])->name('store')->middleware(['auth', 'role:admin,manager,staff']);
    Route::get('/userList', [UserController::class, 'userList'])->name('userList')->middleware(['auth', 'role:admin,manager,staff']);
    Route::get('/userEdit/{id}', [UserController::class, 'userEdit'])->name('userEdit')->middleware(['auth', 'role:admin,manager,staff']);
    Route::put('/userUpdate/{id}', [UserController::class, 'userUpdate'])->name('userUpdate')->middleware(['auth', 'role:admin,manager,staff']);
});
Route::get('/mealplan', [KitchenController::class, 'mealplan'])->name('mealplan')->middleware(['auth', 'role:admin,manager,staff,user']);
Route::get('/registerMealPlan', [KitchenController::class, 'registerMealPlan'])->name('registerMealPlan')->middleware(['auth', 'role:admin,manager,staff']);
Route::get('/mealFoods', [KitchenController::class, 'mealFoods'])->name('mealFoods')->middleware(['auth', 'role:admin,manager,staff']);
Route::post('/mealFoods/store', [KitchenController::class, 'storeMealFood'])->name('mealFoods.store')->middleware(['auth', 'role:admin,manager,staff']);
Route::post('/registerMealPlan/store', [KitchenController::class, 'registerMealPlans'])->name('registerMealPlan/store')->middleware(['auth', 'role:admin,manager,staff']);
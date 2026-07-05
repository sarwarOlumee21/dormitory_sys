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


Route::get('/', [ResidentController::class, 'index'])->name('home')->middleware('auth');
Route::prefix('resident')->name('resident.')->group(function () {
    Route::get('/resident_register', [ResidentController::class, 'ResidentRegister'])->name('register')->middleware('auth');
    Route::get('/resident_list', [ResidentController::class, 'ResidentList'])->name('list')->middleware('auth');
});
Route::prefix('rooms')->name('rooms.')->group(function () {
    Route::get('/room_register', [RoomController::class, 'RoomRegister'])->name('register')->middleware('auth');
    Route::get('/room_list', [RoomController::class, 'RoomList'])->name('list')->middleware('auth');
});
Route::prefix('contracts')->name('contracts.')->group(function () {
    Route::get('/contracts_register', [ContractsController::class, 'ContractsRegister'])->name('register')->middleware('auth');
    Route::get('/contracts_rules', [ContractsController::class, 'ContractsRules'])->name('rules')->middleware('auth');
    Route::post('/rules/save', [ContractsController::class, 'storeRules'])->name('rules.save')->middleware('auth');
    Route::get('/contracts_list', [ContractsController::class, 'ContractsList'])->name('list')->middleware('auth');
    Route::post('/store', [ContractsController::class, 'contractStore'])->name('store')->middleware('auth');
    Route::post('/payment/store', [ContractsController::class, 'storePayment'])->name('payment.store')->middleware('auth');
});
Route::prefix('visitors')->name('visitors.')->group(function () {
    Route::get('/register', [VisitorController::class, 'register'])->name('register')->middleware('auth');
    Route::get('/list', [VisitorController::class, 'list'])->name('list')->middleware('auth');
});
Route::prefix('maintenance')->name('maintenance.')->group(function () {
    Route::get('/register', [MaintenanceController::class, 'register'])->name('register ')->middleware('auth');
    Route::get('/request', [MaintenanceController::class, 'request'])->name('request')->middleware('auth');
    Route::post('/request', [MaintenanceController::class, 'saveRequestType'])->name('request.save')->middleware('auth');
    Route::get('/list', [MaintenanceController::class, 'list'])->name('list')->middleware('auth');
});
Route::prefix('announcements')->name('announcements.')->group(function () {
    Route::get('/register', [AnnouncementController::class, 'register'])->name('register')->middleware('auth');
    Route::get('/list', [AnnouncementController::class, 'list'])->name('list')->middleware('auth');
});
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('/resident/store', [ResidentController::class, 'store'])->name('resident.store');
Route::post('/rooms/store', [RoomController::class, 'store'])->name('rooms.store');
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::post('/loginform', [AuthenticationController::class, 'login'])->name('loginform');
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/userRegister', [UserController::class, 'userRegister'])->name('userRegister')->middleware('auth');
    Route::post('/store', [UserController::class, 'userStore'])->name('store');
    Route::get('/userList', [UserController::class, 'userList'])->name('userList')->middleware('auth');
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ReportController;


Route::get('/',[ResidentController::class, 'index'])->name('home');
Route::prefix('resident')->name('resident.')->group(function () {
    Route::get('/resident_register',[ResidentController::class, 'ResidentRegister'])->name('register');
    Route::get('/resident_list',[ResidentController::class, 'ResidentList'])->name('list');
});
Route::prefix('rooms')->name('rooms.')->group(function () {
    Route::get('/room_register', [RoomController::class, 'RoomRegister'])->name('register');
    Route::get('/room_list', [RoomController::class, 'RoomList'])->name('list');
});
Route::prefix('contracts')->name('contracts.')->group(function () {
    Route::get('/contracts_register', [ContractsController::class, 'ContractsRegister'])->name('register');
    Route::get('/contracts_rules', [ContractsController::class, 'ContractsRules'])->name('rules');
    Route::post('/contracts_rules', [ContractsController::class, 'SaveContractRules'])->name('rules.save');
    Route::get('/contracts_list', [ContractsController::class, 'ContractsList'])->name('list');
});
Route::prefix('visitors')->name('visitors.')->group(function () {
    Route::get('/register', [VisitorController::class, 'register'])->name('register');
    Route::get('/list', [VisitorController::class, 'list'])->name('list');
});
Route::prefix('maintenance')->name('maintenance.')->group(function () {
    Route::get('/register', [MaintenanceController::class, 'register'])->name('register ');
    Route::get('/request', [MaintenanceController::class, 'request'])->name('request');
    Route::post('/request', [MaintenanceController::class, 'saveRequestType'])->name('request.save');
    Route::get('/list', [MaintenanceController::class, 'list'])->name('list');
});
Route::prefix('announcements')->name('announcements.')->group(function () {
    Route::get('/register', [AnnouncementController::class, 'register'])->name('register');
    Route::get('/list', [AnnouncementController::class, 'list'])->name('list');
});
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::post('/resident/store', [ResidentController::class, 'store'])->name('resident.store');
Route::post('/rooms/store', [RoomController::class, 'store'])->name('rooms.store');

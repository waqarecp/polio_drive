<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\TehsilController;
use App\Http\Controllers\Admin\UnionCounsilController;
use App\Http\Controllers\Admin\HouseholdController;
use App\Http\Controllers\AssignedWorkerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Admin Routes (protected by auth middleware)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Resource routes for each administrative level
    Route::resource('provinces', ProvinceController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('districts', DistrictController::class);
    Route::resource('tehsils', TehsilController::class);
    Route::resource('union_councils', UnionCounsilController::class);
    Route::resource('households', HouseholdController::class);

    // Custom routes for managing workers
    Route::get('workers', [AssignedWorkerController::class, 'index'])->name('workers.index');
    Route::post('workers', [AssignedWorkerController::class, 'assign'])->name('workers.assign');
    
    // Polio worker specific routes
    Route::resource('assigned_union_councils', HouseholdController::class);
    Route::post('pick_household/{id}', [AssignedWorkerController::class, 'pickHousehold'])->name('pick_household');
    Route::get('household_members/{id}', [HouseholdController::class, 'showHouseholdMembers'])->name('household_members');
});

Route::resource('home', App\Http\Controllers\HomeController::class);

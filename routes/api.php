<?php
 

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MikrotikController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IpAddressController;
use App\Http\Controllers\BandwidthController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/mikrotik/interfaces', [MikrotikController::class, 'getRouterData']);

Route::get('/mikrotik/users', [UserController::class, 'getUsers'])->name('mikrotik.user.list');
Route::get('/mikrotik/user/new', [UserController::class, 'create'])->name('mikrotik.user.create');
Route::post('/mikrotik/user/add', [UserController::class, 'add'])->name('mikrotik.user.add');
Route::get('/mikrotik/user/{id}', [UserController::class, 'delete'])->name('mikrotik.user.delete');

Route::get('/mikrotik/ipaddress', [IpAddressController::class, 'get'])->name('mikrotik.ipaddress.list');
Route::get('/mikrotik/ipaddress/new', [IpAddressController::class, 'create'])->name('mikrotik.ipaddress.create');
Route::post('/mikrotik/ipaddress/store', [IpAddressController::class, 'add'])->name('mikrotik.ipaddress.add');
Route::get('/mikrotik/ipaddress/{id}', [IpAddressController::class, 'delete'])->name('mikrotik.ipaddress.delete');

Route::get('/mikrotik/bandwidth', [BandwidthController::class, 'get'])->name('mikrotik.bandwidth.list');
Route::get('/mikrotik/bandwidth/new', [BandwidthController::class, 'create'])->name('mikrotik.bandwidth.create');
Route::post('/mikrotik/bandwidth/store', [BandwidthController::class, 'add'])->name('mikrotik.bandwidth.add');
Route::get('/mikrotik/bandwidth/{id}', [BandwidthController::class, 'delete'])->name('mikrotik.bandwidth.delete');

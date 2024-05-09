<?php

use Illuminate\Support\Facades\{Route, Auth};
use App\Http\Controllers\{CustomerController, VisitController, DashboardController, DeviceController, UserController, ComponentController, MessageController, ReceiverController, FwallController};

//CUSTOMER
Route::get('/customers/{string?}', [CustomerController::class, 'index'])->name('customers.index');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::patch('/customers/{id}', [CustomerController::class, 'update'])->name('customers.state');
//DEVICES
Route::get('/devices/{id}/{string_find?}', [DeviceController::class, 'index'])->name('devices.index');
Route::get('/pdf/{id}/{string_find?}', [DeviceController::class, 'pdf'])->name('devices.pdf');

Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');
Route::delete('/devices/{id}', [DeviceController::class, 'destroy'])->name('devices.destroy');
//USER
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::patch('/users/password', [UserController::class, 'password'])->name('users.password');
//COMPONENT
Route::get('/components/{id}/{type}', [ComponentController::class, 'index'])->name('components.index');
Route::post('/components', [ComponentController::class, 'store'])->name('components.store');
Route::patch('/components/{id}', [ComponentController::class, 'low'])->name('components.low');
Route::delete('/components/{id}', [ComponentController::class, 'destroy'])->name('components.destroy');
//Actualizar Componente
Route::get('/components-u/{id}', [ComponentController::class, 'show'])->name('components.show');
Route::get('/components-hw', [ComponentController::class, 'hw'])->name('components.hw');
Route::post('/components-u', [ComponentController::class, 'update'])->name('components.update');
//
//MESSAGE
Route::get('/messages/create/{id?}', [MessageController::class, 'create'])->name('messages.create');
Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
Route::get('/image/{filename}', [MessageController::class, 'image'])->name('messages.image');
Route::post('/receiver', [ReceiverController::class, 'store'])->name('receiver.store');
Route::get('/state/{id}', [ReceiverController::class, 'state'])->name('state.index');
Route::get('/visit/{token}/{id}', [VisitController::class, 'visit'])->name('visit.index');
//DASHBOARD
Route::get('/dashboard/{id}', [DashboardController::class, 'dashboard'])->name('hardware.dashboard');
Route::get('/pdfu/{id}/{string_find?}', [DashboardController::class, 'pdfu'])->name('devices.pdfu');
Route::get('/detail/{customer}/{id}', [DashboardController::class, 'detail'])->name('list.index');
Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});
// Firewall Json
Route::get('/fwall/{fwall}', [FwallController::class, 'show'])->name('fwall.show');

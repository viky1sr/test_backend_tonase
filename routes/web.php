<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return \Spatie\Activitylog\Models\Activity::all();
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/info-transfer','TransaksiController');
Route::get('/history-top-up','TransaksiController@indexTopUp')->name('history-top-up.index');
Route::get('/history-withdraw','TransaksiController@indexWithdraw')->name('withdraw.index');
Route::post('/register-acc-saldo','TransaksiController@storeAcc')->name('register-acc-saldo.store');
Route::post('/transfer-saldo','TransaksiController@storeTransfer')->name('transfer-saldo.store');
Route::post('/top-up-saldo','TransaksiController@storeTopUp')->name('top-up-saldo.store');
Route::post('/withdraw-saldo','TransaksiController@storeWithdraw')->name('withdraw-saldo.store');

<?php

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Settings;
use App\Http\Livewire\Ticketing;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::middleware('keycloak-web')->get('/', Dashboard::class)->name('home');
Route::middleware('keycloak-web')->get('/settings', Settings::class)->name('settings');
Route::middleware('keycloak-web')->get('/ticketing', Ticketing::class)->name('ticketing');

//Route::middleware('keycloak-web')->get('/ldap', SyncLDAP::class);

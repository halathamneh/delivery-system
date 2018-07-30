<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function() {
    Route::get('shipments/returned', "ShipmentController@returned")->name('shipments.returned');
    Route::get('shipments/create/{type?}', "ShipmentController@create")
        ->name('shipments.create')
        ->where('type', 'wizard|legacy');
    Route::get('shipments/{shipment}/{tab?}', "ShipmentController@show")
        ->name('shipments.show')
        ->where('tab', 'summery|details|actions|status');
    Route::resource('shipments', "ShipmentController")->except(['create', 'show']);

    Route::put('shipments/{shipment}/return', "ShipmentController@makeReturn")->name('shipments.return');

    Route::resource('zones', "ZoneController");
    Route::resource('zones/{zone}/address', "AddressController");

    Route::resource('users/roles', "UserTemplatesController");
    Route::resource('users', "UsersController");

    Route::get('clients/create', "ClientsController@create")->name('clients.create');
    Route::get('clients/{client}/{tab?}', "ClientsController@show")
        ->name('clients.show');
    Route::resource('clients', "ClientsController")->except(['show', 'create']);

    Route::resource('couriers', "CouriersController");
    Route::resource('pickups', "PickupsController");
    Route::resource('settings', "SettingsController");
    Route::resource('notes', "NotesController");
});

// Localization
Route::get('/js/lang.js', function () {
    //$strings = Cache::rememberForever('lang.js', function () {
    $lang = config('app.locale');

    $files = glob(resource_path('lang/' . $lang . '/*.php'));
    $strings = [];

    foreach ($files as $file) {
        $name = basename($file, '.php');
        $strings[$name] = require $file;
    }

    //return $strings;
    //});

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    echo('window.trans = function(text){return window.i18n[text];}');
    exit();
})->name('assets.lang');
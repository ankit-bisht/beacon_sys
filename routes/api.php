<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'prefix' => 'beacon_sys'
], function () {
    Route::post('fetchnodes', 'BeaconController@fetchNodes');
    Route::post('addBeacon', 'AdminController@create');
    Route::get('showBeacon', 'AdminController@show');
    Route::get('getBeaconList', 'AdminController@getBeaconList');
});


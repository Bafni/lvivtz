<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
/**/
Route::post('crm-a', '\App\Http\Controllers\CRM\CrmAController');
Route::post('crm-b', '\App\Http\Controllers\CRM\CrmBController');


Route::group(['prefix' => 'integration'], function () {
    Route::get('/', function () {
       return response()->json(\App\Components\IntegrationFactory::integrationList()) ;
    });
});

Route::group(['prefix' => 'signup', 'namespace' => '\App\Http\Controllers\Integration\\'], function () {
    Route::post('/', 'IntegrationController');
    Route::get('/test', function () {
        return response()->json(['status' => 'ok']);
    });

});

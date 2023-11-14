<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiDelegationController;
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

Route::post('getauthcode', [ApiDelegationController::class, 'getauthcode'])->name('apidelegation.getauthcode');
Route::post('storedelegation', [ApiDelegationController::class, 'storedelegation'])->name('apidelegation.storedelegation');
Route::get('delegationreport/{userid}', [ApiDelegationController::class, 'delegationreport'])->name('apidelegation.delegationreport');

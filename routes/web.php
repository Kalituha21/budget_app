<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::post('balance/get-user-balance', 'BalanceDataController@getUserBalance');

Route::post('balance/save-asset', 'BalanceDataController@saveAsset');
Route::post('balance/save-liability', 'BalanceDataController@saveLiability');
Route::post('balance/save-income', 'BalanceDataController@saveIncome');
Route::post('balance/save-expense', 'BalanceDataController@saveExpense');

Route::post('balance/edit-asset', 'BalanceDataController@editAsset');
Route::post('balance/edit-liability', 'BalanceDataController@editLiability');
Route::post('balance/edit-income', 'BalanceDataController@editIncome');
Route::post('balance/edit-expense', 'BalanceDataController@editExpense');

Route::post('balance/delete-asset', 'BalanceDataController@deleteAsset');
Route::post('balance/delete-liability', 'BalanceDataController@deleteLiability');
Route::post('balance/delete-income', 'BalanceDataController@deleteIncome');
Route::post('balance/delete-expense', 'BalanceDataController@deleteExpense');

Route::post('currency/get-rates', 'CurrencyDataController@getTodayRates');
Route::post('currency/api-list', 'CurrencyDataController@getApiCurrencies');

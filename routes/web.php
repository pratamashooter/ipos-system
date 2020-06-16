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
    return view('welcome');
});

Route::get('/login', 'AuthManageController@viewLogin')->name('login');
Route::post('/verify_login', 'AuthManageController@verifyLogin');
Route::post('/first_account', 'UserManageController@firstAccount');

Route::group(['middleware' => ['auth', 'checkRole:admin,kasir']], function(){
	Route::get('/logout', 'AuthManageController@logoutProcess');
	Route::get('/dashboard', 'ViewManageController@viewDashboard');
	Route::get('/dashboard/chart/{filter}', 'ViewManageController@filterChartDashboard');
	Route::post('/market/update', 'ViewManageController@updateMarket');
	// ------------------------- Fitur Cari -------------------------
	Route::get('/search/{word}', 'SearchManageController@searchPage');
	// ------------------------- Profil -------------------------
	Route::get('/profile', 'ProfileManageController@viewProfile');
	Route::post('/profile/update/data', 'ProfileManageController@changeData');
	Route::post('/profile/update/password', 'ProfileManageController@changePassword');
	Route::post('/profile/update/picture', 'ProfileManageController@changePicture');
	// ------------------------- Kelola Akun -------------------------
	// > Akun
	Route::get('/account', 'UserManageController@viewAccount');
	Route::get('/account/new', 'UserManageController@viewNewAccount');
	Route::post('/account/create', 'UserManageController@createAccount');
	Route::get('/account/edit/{id}', 'UserManageController@editAccount');
	Route::post('/account/update', 'UserManageController@updateAccount');
	Route::get('/account/delete/{id}', 'UserManageController@deleteAccount');
	Route::get('/account/filter/{id}', 'UserManageController@filterTable');
	// > Akses
	Route::get('/access', 'AccessManageController@viewAccess');
	Route::get('/access/change/{user}/{access}', 'AccessManageController@changeAccess');
	Route::get('/access/check/{user}', 'AccessManageController@checkAccess');
	Route::get('/access/sidebar', 'AccessManageController@sidebarRefresh');
	// ------------------------- Kelola Barang -------------------------
	// > Barang
	Route::get('/product', 'ProductManageController@viewProduct');
	Route::get('/product/new', 'ProductManageController@viewNewProduct');
	Route::post('/product/create', 'ProductManageController@createProduct');
	Route::post('/product/import', 'ProductManageController@importProduct');
	Route::get('/product/edit/{id}', 'ProductManageController@editProduct');
	Route::post('/product/update', 'ProductManageController@updateProduct');
	Route::get('/product/delete/{id}', 'ProductManageController@deleteProduct');
	Route::get('/product/filter/{id}', 'ProductManageController@filterTable');
	// > Pasok
	Route::get('/supply/system/{id}', 'SupplyManageController@supplySystem');
	Route::get('/supply', 'SupplyManageController@viewSupply');
	Route::get('/supply/new', 'SupplyManageController@viewNewSupply');
	Route::get('/supply/check/{id}', 'SupplyManageController@checkSupplyCheck');
	Route::get('/supply/data/{id}', 'SupplyManageController@checkSupplyData');
	Route::post('/supply/create', 'SupplyManageController@createSupply');
	Route::post('/supply/import', 'SupplyManageController@importSupply');
	Route::get('/supply/statistics', 'SupplyManageController@statisticsSupply');
	Route::get('/supply/statistics/product/{id}', 'SupplyManageController@statisticsProduct');
	Route::get('/supply/statistics/users/{id}', 'SupplyManageController@statisticsUsers');
	Route::get('/supply/statistics/table/{id}', 'SupplyManageController@statisticsTable');
	Route::post('/supply/statistics/export', 'SupplyManageController@exportSupply');
	// ------------------------- Transaksi -------------------------
	Route::get('/transaction', 'TransactionManageController@viewTransaction');
	Route::get('/transaction/product/{id}', 'TransactionManageController@transactionProduct');
	Route::get('/transaction/product/check/{id}', 'TransactionManageController@transactionProductCheck');
	Route::post('/transaction/process', 'TransactionManageController@transactionProcess');
	Route::get('/transaction/receipt/{id}', 'TransactionManageController@receiptTransaction');
	// ------------------------- Kelola Laporan -------------------------
	Route::get('/report/transaction', 'ReportManageController@reportTransaction');
	Route::post('/report/transaction/filter', 'ReportManageController@filterTransaction');
	Route::get('/report/transaction/chart/{id}', 'ReportManageController@chartTransaction');
	Route::post('/report/transaction/export', 'ReportManageController@exportTransaction');
	Route::get('/report/workers', 'ReportManageController@reportWorker');
	Route::get('/report/workers/filter/{id}', 'ReportManageController@filterWorker');
	Route::get('/report/workers/detail/{id}', 'ReportManageController@detailWorker');
	Route::post('/report/workers/export/{id}', 'ReportManageController@exportWorker');
});

// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
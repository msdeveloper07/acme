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

Route::get('/', function () {
    return view('welcome');
});

//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});


//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});


Route::get('/install-app', 'InstallShopifyAppController@install');
Route::get('/generate-token-app', 'InstallShopifyAppController@generateToken');
Route::any('/Update-panel', 'InstallShopifyAppController@update_panel')->name("update-panel");
Route::any('/update-customer-tag', 'InstallShopifyAppController@updateCustomerTag');
Route::any('/upload-image', 'InstallShopifyAppController@uploadImage');

Route::any('/referrals/{id}', 'InstallShopifyAppController@affiliateReferral');

Route::any('/get-panel-text', 'AffiliateController@get_panel_text');
Route::any('/update-status', 'AffiliateController@updateStatus');
Route::any('/update-commission', 'AffiliateController@updateCommission');
Route::any('/update-credits', 'AffiliateController@updateCredits');
Route::any('/form-submit', 'AffiliateController@storeAffiliateForm');
Route::any('/api/get-customer-data', 'AffiliateController@getCustomerData');
Route::any('/api/get-referrals-data', 'AffiliateController@getReferralsData');
Route::any('/api/get-tier-redemables', 'AffiliateController@getTierRedem');
Route::any('/company-form-submit', 'AffiliateController@submitCompanyForm');

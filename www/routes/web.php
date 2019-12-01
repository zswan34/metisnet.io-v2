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


Route::middleware('guest')->group(function() {
    Route::get('/', ['uses' => 'HomeController@index'])->name('home');
    Route::get('/sign-in', ['uses' => 'AuthController@getSignIn'])->name('get-sign-in');
    Route::post('/sign-in', ['uses' => 'AuthController@postSignIn'])->name('post-sign-in');
    Route::get('/create-account', ['uses' => 'AccountController@getCreateAccount'])->name('get-create-account');
    Route::post('/create-account', ['uses' => 'AccountController@postCreateAccount'])->name('post-create-account');
    Route::get('/forgot-password', ['uses' => 'AuthController@getForgotPassword'])->name('get-forgot-password');
    Route::post('/forgot-password', ['uses' => 'AuthController@postForgotPassword'])->name('post-forgot-password');
});

Route::middleware('auth')->group(function() {

    Route::get('/logout', ['uses' => 'AccountController@logout'])->name('get-logout');

    Route::get('/setup', ['uses' => 'AccountController@getSetup'])->name('get-setup');
    Route::post('/setup', ['uses' => 'AccountController@postSetup'])->name('post-setup');

    Route::get('/photos/{user_uid}/{uuid}/{name}/', ['uses' => 'ImageController@getAvatar'])->name('get-avatar');

    Route::middleware('setup')->group(function() {

        Route::get('/accounts', ['uses' => 'UserController@getUsers'])->name('get-users');
        Route::get('/accounts/{uid}', ['uses' => 'UserController@getUser'])->name('get-user');

        Route::get('/home', ['uses' => 'AccountController@index'])->name('get-index');
        Route::get('/budgets', ['uses' => 'BudgetController@getBudgets'])->name('get-budgets');
        Route::get('/budgets/builder', ['uses' => 'BudgetController@getBudgetBuilder'])->name('get-budget-builder');

        Route::get('/domains', ['uses' => 'DomainController@getDomainAccounts'])->name('get-domains');
        Route::post('/domains', ['uses' => 'DomainController@postDomains'])->name('post-domains');
        Route::get('/domains/{domain_account_uid}', ['uses' => 'DomainController@getDomains'])->name('get-domain');
        Route::get('/domains/{domain_account_uid}/{domain_name}', ['uses' => 'DomainController@getDomainDnsItems'])->name('get-domain-dns-items');

        Route::get('/domains/godaddy', ['uses' => 'DomainController@getGodaddyDomains'])->name('get-domains-godaddy');

        Route::get('/my-account', ['uses' => 'AccountController@getMyAccount'])->name('get-my-account');
        Route::post('/upload-my-account-avatar', ['uses' => 'UploadController@avatarUpload'])->name('post-avatar-upload');

        Route::get('/roles-and-permissions', ['uses' => 'RolesAndPermissionsController@getRolesAndPermissions'])->name('get-roles-and-permissions');

        Route::post('/settings/layout/direction', ['uses' => 'SettingController@direction'])->name('post-settings-layout-direction');
        Route::post('/settings/style/material', ['uses' => 'SettingController@material'])->name('post-settings-style-material');
        Route::post('/settings/layout/style', ['uses' => 'SettingController@layoutStyle'])->name('post-settings-layout-style');
        Route::post('/settings/layout/navbar-fixed', ['uses' => 'SettingController@navbarFixed'])->name('post-settings-layout-navbar-fixed');
        Route::post('/settings/layout/footer-fixed', ['uses' => 'SettingController@footerFixed'])->name('post-settings-layout-footer-fixed');
        Route::post('/settings/layout/reversed', ['uses' => 'SettingController@reversed'])->name('post-settings-layout-reversed');
        Route::post('/settings/color/theme', ['uses' => 'SettingController@theme'])->name('post-settings-color-theme');



        Route::get('/servers', ['uses' => 'ServerController@getServers'])->name('get-servers');
        Route::get('/servers/{server_id}', ['uses' => 'ServerController@getServer'])->name('get-server');

        Route::get('/settings', ['uses' => 'ApplicationController@getApplicationSettings'])->name('get-application-settings');
        Route::get('/{account_uid}', ['uses' => 'AccountController@getAccount'])->name('get-account');

        Route::prefix('/api/v1')->group(function() {
            Route::get('/users', ['uses' => 'UserController@getUsersApi'])->name('get-users-api');
            Route::get('/users/{uid}', ['uses' => 'UserController@getUserApi'])->name('get-user-api');
            Route::post('/users/{uid}', ['uses' => 'UserController@postUserApi'])->name('post-user-api');
            Route::get('/users/{uid}/activity', ['uses' => 'UserController@getUserActivitiesApi'])->name('get-user-activity-api');

            Route::get('/auth', ['uses' => 'AuthController@getAuthUserApi'])->name('get-auth-user-api');

            Route::get('/domains', ['uses' => 'DomainController@getDomainAccountsApi'])->name('get-domains-api');
            Route::get('/domains/{domain_account_uid}/', ['uses' => 'DomainController@getDomainsApi'])->name('get-domain-api');
            Route::post('/domains/{domain_account_uid}/edit', ['uses' => 'DomainController@editDomainAccountApi'])->name('edit-domain-account-api');
            Route::delete('/domains/{domain_account_uid}', ['uses' => 'DomainController@deleteDomainAccountApi'])->name('delete-domain-account-api');
            Route::get('/domains/{domain_account_uid}/{domain_name}/', ['uses' => 'DomainController@getDomainDnsItemsApi'])->name('get-domain-dns-items-api');
            Route::post('domains/{domain_account_id}/{domain_name}/edit-record', ['uses' => 'DomainController@editDnsRecordByName'])->name('post-edit-dns-record');

            Route::get('/roles', ['uses' => 'RolesAndPermissionsController@getRolesApi'])->name('get-roles-api');
            Route::post('/roles/create', ['uses' => 'RolesAndPermissionsController@createRolesApi'])->name('create-roles-api');
            Route::post('/roles/{roles_name}/edit', ['uses' => 'RolesAndPermissionsController@editRolesApi'])->name('edit-roles-api');
            Route::delete('/roles/{roles_name}/edit', ['uses' => 'RolesAndPermissionsController@deleteRolesApi'])->name('delete-roles-api');
            Route::get('/roles/{role_name}/details', ['uses' => 'RolesAndPermissionsController@getRolesDetails'])->name('get-roles-details');
            Route::get('/roles/{uid}', ['uses' => 'RolesAndPermissionsController@getRolesByUidApi'])->name('get-roles-by-uid-api');
            Route::get('/roles/{name}/permissions', ['uses' => 'RolesAndPermissionsController@getPermissionsFromRoleName'])->name('get-permissions-from-role-name');

            Route::get('/permissions', ['uses' => 'RolesAndPermissionsController@getPermissionsApi'])->name('get-permissions-api');

            Route::get('/servers', ['uses' => 'ServerController@getServerApi'])->name('get-servers-api');
            Route::get('/servers/{server_id}', ['uses' => 'ServerController@getServerApiShow'])->name('get-servers-api-show');


        });

    });
});
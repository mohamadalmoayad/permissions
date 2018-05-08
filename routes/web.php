<?php

use Almoayad\Permissions\middleware\checkPrivilege;
use Almoayad\Permissions\middleware\checkPermissionsAdmins;
use Almoayad\Permissions\middleware\checkSecurity;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::Resource('/admins-permissions', '\Almoayad\Permissions\controllers\permissionAdminsController')->middleware(checkSecurity::class);
Route::Resource('/links-prefixes', '\Almoayad\Permissions\controllers\LinkPrefixesController')->middleware(checkPermissionsAdmins::class);
Route::Resource('/permissions', '\Almoayad\Permissions\controllers\permissionController')->middleware(checkPermissionsAdmins::class);
Route::post('/get-permissions', '\Almoayad\Permissions\controllers\permissionController@getUserPermissions')->name('get-permissions')->middleware(checkPermissionsAdmins::class);
Route::get('/error/no-permission', '\Almoayad\Permissions\controllers\permissionController@showNoPermission');

Route::resource('/test', 'TestController')->middleware(checkPrivilege::class);
Route::resource('/spare-parts', 'TestController')->middleware(checkPrivilege::class);
Route::resource('/phones', 'TestController')->middleware(checkPrivilege::class);

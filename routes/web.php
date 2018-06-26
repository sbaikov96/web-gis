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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/adduser', 'adduser@home')->name('adduser');
Route::get('/methods', 'methods@home')->name('methods');
Route::get('/ListUser', 'ListUser@home')->name('ListUser');

Route::match(['get', 'post'], 'detail', function () {
	return view("detail");
});
Route::match(['get', 'post'], 'Admin', function () {
	return view("Admin");
});
Route::match(['get', 'post'], '404', function () {
	return view("404");
});

Route::match(['get', 'post'], 'DetailGarage', function () {
	return view("DetailGarage");
});

Route::match(['get', 'post'], 'adduser', function () {
	return view("adduser");
});

Route::match(['get', 'post'], 'ManagerAuto', function () {
	return view("ManagerAuto");
});

Route::match(['get', 'post'], 'List', function () {
	return view("List");
});

Route::match(['get', 'post'], 'addcase', function () {
	return view("addcase");
});

Route::match(['get', 'post'], 'CreateList', function () {
	return view("CreateList");
});

Route::match(['get', 'post'], 'UpdateList', function () {
	return view("UpdateList");
});
Route::match(['get', 'post'], 'AddGarage', function () {
	return view("AddGarage");
});

Route::match(['get', 'post'], 'ManagerGarage', function () {
	return view("ManagerGarage");
});
Route::match(['get', 'post'], 'Task', function () {
	return view("Task");
});

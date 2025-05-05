<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/admin', '/admin/login')->name('admin.login');
Route::redirect('/employee', '/employee/login')->name('employee.login');
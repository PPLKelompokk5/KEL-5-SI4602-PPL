<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing.welcome');
});

Route::redirect('/admin', '/admin/login')->name('admin.login');
Route::redirect('/employee', '/employee/login')->name('employee.login');
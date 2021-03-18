<?php

use Illuminate\Support\Facades\Route;
Route::get('/welcome', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('edit_form', [ App\Http\Controllers\FormsController::class, 'create'])->name('create_form');
Route::post('edit_form', [ App\Http\Controllers\FormsController::class, 'editing' ]);
Route::get('edit_form/{id}', [ App\Http\Controllers\FormsController::class, 'editForm']);
Route::post('edit_form/{id}', [ App\Http\Controllers\FormsController::class, 'editing' ])->name('edit_form');
Route::get('/', [ App\Http\Controllers\FormsController::class, 'showAllForms'])->name('forms');
Route::get('fill_in_form/{id}', [ App\Http\Controllers\FormsController::class, 'fill' ])->name('fill_in_form');
Route::post('fill_in_form/{id}', [ App\Http\Controllers\FormsController::class, 'filling' ])->name('filling_in_form');
Route::get('form_results/{id}', [ App\Http\Controllers\FormsController::class, 'results' ])->name('form_results');

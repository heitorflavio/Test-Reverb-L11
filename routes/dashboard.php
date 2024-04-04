<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::controller(App\Http\Controllers\CalendarController::class)->group(function () {
        Route::group(['prefix' => 'calendar'],  function () {
                Route::get('/', 'calendar')->name('calendar.calendar');
                Route::get('/list', 'index')->name('calendar.index');
                Route::get('create', 'create')->name('calendar.create');
                Route::post('store', 'store')->name('calendar.store');
                Route::get('edit/{id}', 'edit')->name('calendar.edit');
                Route::post('update/{id}', 'update')->name('calendar.update');
                Route::get('delete/{id}', 'delete')->name('calendar.delete');
            });
        });

    Route::controller(App\Http\Controllers\AppointmentController::class)->group(function () {
        Route::group(['prefix' => 'events'],  function () {
            Route::get('/', 'index')->name('appointment.index');
            Route::get('create', 'create')->name('appointment.create');
            Route::post('store', 'store')->name('appointment.store');
            Route::get('edit/{id}', 'edit')->name('appointment.edit');
            Route::put('update/{appointment}', 'update')->name('appointment.update');
            Route::delete('delete/{appointment}', 'destroy')->name('appointment.delete');
        });
    });
});

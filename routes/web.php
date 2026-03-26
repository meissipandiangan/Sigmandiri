<?php

use App\Http\Controllers\GugatanController;
use Illuminate\Support\Facades\Route;


Route::get('/', [GugatanController::class, 'home'])->name('home');

Route::get('/pilih-jenis', [GugatanController::class, 'index'])->name('gugatan.index');

Route::get('/gugatan/create/{jenis}', [GugatanController::class, 'create'])->name('gugatan.create');

Route::post('/gugatan/store', [GugatanController::class, 'store'])->name('gugatan.store');

Route::get('/gugatan/download/{file}', [GugatanController::class, 'downloadDirect'])->name('gugatan.download.direct');
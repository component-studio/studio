<?php

use Illuminate\Support\Facades\Route;

Route::view('components', 'componentstudio::components')->middleware('web');
Route::view('test/components', 'componentstudio::components')->middleware('web');

<?php

use Illuminate\Support\Facades\Route;

Route::view('components', 'studio::components')->middleware('web');

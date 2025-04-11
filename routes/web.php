<?php

use Illuminate\Support\Facades\Route;
use App\Models\Hospital;

Route::get('/', function () {
    return view('dashboard.index', ['title' => 'Dashboard']);
});

Route::get('/hospitals', function() {
    return view('hospitals.index', ['title' => 'Hospitals']);
});

Route::get('/patients', function() {
    $hospitals = Hospital::all();
    return view('patients.index', ['title' => 'Patients', 'hospitals' => $hospitals]);
});

Route::get('/login', function() {
    return view('login');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictController;
// use Illuminate\Support\Facades\Storage;
// use Google\Cloud\Storage\StorageClient;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
Route::get('/dashboard', function () {
    $title = 'Cunny | Dashboard';
    return view('dashboard', compact('title'));
    })->name('dashboard');

Route::get('/img-classify', [PredictController::class, 'index'
    ])->name('img-classify.index');

Route::post('/img-classify', [PredictController::class, 'predict'
    ])->name('img-classify.store');

Route::get('/img-classify/result', [PredictController::class, 'result'
    ])->name('img-classify.result');
});

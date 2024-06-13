<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AssetController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-test-email', function () {
    Mail::to('info@deanhattingh.co.za')->send(new TestEmail());
    return 'Test email sent!';
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('clients', ClientController::class);

Route::prefix('assets')->group(function () {
    Route::get('create/step1', [AssetController::class, 'createStep1'])->name('assets.create.step1');
    Route::post('create/step1', [AssetController::class, 'postCreateStep1'])->name('assets.create.step1.post');

    Route::get('create/step2', [AssetController::class, 'createStep2'])->name('assets.create.step2');
    Route::post('create/step2', [AssetController::class, 'postCreateStep2'])->name('assets.create.step2.post');

    Route::get('create/step3', [AssetController::class, 'createStep3'])->name('assets.create.step3');
    Route::post('create/step3', [AssetController::class, 'postCreateStep3'])->name('assets.create.step3.post');

    Route::get('create/step4', [AssetController::class, 'createStep4'])->name('assets.create.step4');
    Route::post('create/step4', [AssetController::class, 'postCreateStep4'])->name('assets.create.step4.post');

    Route::get('create/step5', [AssetController::class, 'createStep5'])->name('assets.create.step5');
    Route::post('create/step5', [AssetController::class, 'postCreateStep5'])->name('assets.create.step5.post');

    Route::get('create/step6', [AssetController::class, 'createStep6'])->name('assets.create.step6');
    Route::post('create/step6', [AssetController::class, 'postCreateStep6'])->name('assets.create.step6.post');
});

Route::resource('assets', AssetController::class);

require __DIR__.'/auth.php';

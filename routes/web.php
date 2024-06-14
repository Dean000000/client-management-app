<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetExportController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MagicLinkController;
use App\Http\Controllers\Admin\UserController;

Route::get('/login', [MagicLinkController::class, 'showLoginForm'])->name('login');
Route::post('/send-magic-link', [MagicLinkController::class, 'sendMagicLink'])->name('sendMagicLink');
Route::get('/magic-link/{token}', [MagicLinkController::class, 'login'])->name('magicLinkLogin');

// User management routes for admin
Route::middleware(['auth', 'can:manage-users'])->group(function () {
    Route::resource('users', UserController::class);
});
Route::post('assets/update-status/{asset}', [AssetController::class, 'updateStatus'])->name('assets.updateStatus');

Route::prefix('items')->group(function () {
    Route::get('create/step1', [ItemController::class, 'createStep1'])->name('items.create.step1');
    Route::post('create/step1', [ItemController::class, 'postCreateStep1'])->name('items.create.step1.post');

    Route::get('create/step2', [ItemController::class, 'createStep2'])->name('items.create.step2');
    Route::post('create/step2', [ItemController::class, 'postCreateStep2'])->name('items.create.step2.post');

    Route::get('create/step3', [ItemController::class, 'createStep3'])->name('items.create.step3');
    Route::post('create/step3', [ItemController::class, 'postCreateStep3'])->name('items.create.step3.post');

    Route::get('create/step4', [ItemController::class, 'createStep4'])->name('items.create.step4');
    Route::post('create/step4', [ItemController::class, 'postCreateStep4'])->name('items.create.step4.post');

    Route::get('create/step5', [ItemController::class, 'createStep5'])->name('items.create.step5');
    Route::post('create/step5', [ItemController::class, 'postCreateStep5'])->name('items.create.step5.post');

    Route::get('create/step6', [ItemController::class, 'createStep6'])->name('items.create.step6');
    Route::post('create/step6', [ItemController::class, 'postCreateStep6'])->name('items.create.step6.post');
});

Route::resource('items', ItemController::class)->except(['show']);

// Export routes
Route::get('items/export', [ItemController::class, 'exportAll'])->name('items.export.all');
Route::get('items/export/client/{client}', [ItemController::class, 'exportByClient'])->name('items.export.client');

Route::get('/', function () {
    return redirect()->route('login');
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

// Specify only the routes needed, excluding 'show'
Route::resource('assets', AssetController::class)->except(['show']);

// Export routes
Route::get('assets/export', [AssetExportController::class, 'exportAll'])->name('assets.export.all');
Route::get('assets/export/client/{client}', [AssetExportController::class, 'exportByClient'])->name('assets.export.client');
Route::get('assets/export/client/{client}/status', [AssetExportController::class, 'exportByClientAndStatus'])->name('assets.export.client.status');

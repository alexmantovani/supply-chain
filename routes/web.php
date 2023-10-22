<?php

use App\Http\Controllers\ProfileController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::user()->profile->warehouse_id) {
        return redirect(route('warehouse.show', Auth::user()->profile->warehouse_id));
    }
    return redirect('/warehouse');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    // Route::get('/refill/simulate', [App\Http\Controllers\RefillController::class, 'generateTestCode'])->name('refill.simulate');
    // Route::get('/refill/ask', [App\Http\Controllers\RefillController::class, 'ask'])->name('refill.ask');
    // Route::get('/refill/done', [App\Http\Controllers\RefillController::class, 'requestDone'])->name('refill.done');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/product/{dealer}/create', [App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
    Route::post('/product/discover', [App\Http\Controllers\ProductController::class, 'discover'])->name('product.discover');

    // WAREHOUSE
    // Route::resource('/warehouse', App\Http\Controllers\WarehouseController::class);
    Route::get('/warehouse', [App\Http\Controllers\WarehouseController::class, 'index'])->name('warehouse.index');
    Route::get('/warehouse/create', [App\Http\Controllers\WarehouseController::class, 'create'])->name('warehouse.create');
    Route::get('/warehouse/{warehouse}', [App\Http\Controllers\WarehouseController::class, 'show'])->name('warehouse.show');
    Route::post('/warehouse/store', [App\Http\Controllers\WarehouseController::class, 'store'])->middleware(['permission:create warehouse'])->name('warehouse.store');
    Route::get('/warehouse/{warehouse}/edit', [App\Http\Controllers\WarehouseController::class, 'edit'])->middleware(['permission:edit warehouse'])->name('warehouse.edit');
    Route::patch('/warehouse/{warehouse}/update', [App\Http\Controllers\WarehouseController::class, 'update'])->middleware(['permission:edit warehouse'])->name('warehouse.update');
    Route::delete('/warehouse/{warehouse}', [App\Http\Controllers\WarehouseController::class, 'destroy'])->middleware(['permission:delete warehouse'])->name('warehouse.destroy');

    Route::get('/warehouse/{warehouse}/refill/simulate', [App\Http\Controllers\RefillController::class, 'generateTestCode'])->name('warehouse.refill.simulate');
    // Route::get('/warehouse/{warehouse}/refill/ask', [App\Http\Controllers\RefillController::class, 'ask'])->name('warehouse.refill.ask');
    Route::get('/warehouse/{warehouse}/refill/done', [App\Http\Controllers\RefillController::class, 'requestDone'])->name('refill.done');
    Route::get('/warehouse/{warehouse}/refill/error', [App\Http\Controllers\RefillController::class, 'requestError'])->name('refill.error');
    Route::get('/warehouse/{warehouse}/refill/request', [App\Http\Controllers\RefillController::class, 'request'])->name('refill.request');

    Route::get('/warehouse/{warehouse}/product/checkin', [App\Http\Controllers\ProductController::class, 'checkin'])->name('product.checkin');
    Route::get('/warehouse/{warehouse}/product/delivered', [App\Http\Controllers\ProductController::class, 'delivered'])->name('product.delivered');

    Route::resource('warehouse.dealer', App\Http\Controllers\DealerController::class)->only(['show']);
    Route::resource('warehouse.product', App\Http\Controllers\ProductController::class);
    Route::resource('warehouse.order', App\Http\Controllers\OrderController::class)->only([
        'index', 'show', 'destroy', 'edit'
    ])->middleware(['permission:handle order']);
    Route::get('/warehouse/{warehouse}/order/{order}/complete', [App\Http\Controllers\OrderController::class, 'complete'])->name('order.complete');

    Route::resource('warehouse.refill', App\Http\Controllers\RefillController::class);

    Route::resource('provider', App\Http\Controllers\ProviderController::class);

    Route::get('/order/{order}/completed', [App\Http\Controllers\OrderController::class, 'completed'])->name('order.completed');
    Route::get('/order/{order}/closed', [App\Http\Controllers\OrderController::class, 'closed'])->name('order.closed');

    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->middleware(['permission:admin site'])->name('admin');
    Route::prefix('admin')->group(function () {
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->middleware(['permission:edit user'])->name('admin.users');
        // Route::get('/providers', [App\Http\Controllers\ProviderController::class, 'index'])->middleware(['permission:admin site'])->name('admin.providers');
        Route::resource('provider', App\Http\Controllers\ProviderController::class)->only([
            'index'
        ]);
        Route::get('/products', [App\Http\Controllers\ProductController::class, 'admin'])->name('admin.products');
        Route::get('/warehouses', [App\Http\Controllers\WarehouseController::class, 'adminIndex'])->name('admin.warehouses');
        Route::get('/labels', [App\Http\Controllers\AdminController::class, 'labels'])->name('admin.labels');
        Route::post('/print-labels', [App\Http\Controllers\AdminController::class, 'printLabels'])->name('admin.print-labels');
    })->middleware(['auth', 'permission:admin site']);
});


require __DIR__ . '/auth.php';

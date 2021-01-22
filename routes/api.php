<?php

use App\Http\Controllers\User;
use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;

// remove web middleware, I will see if it's required later.
Route::group(['middleware' => []], function () { // Web middleware to get auth()->user() #code
    Route::get('/health', function () {
        return 'Ok';
    })->name('check.heath');

    Route::post('/timeout/{timeout}', function ($timeout) {
        sleep($timeout);
        return response()->json([
            'success' => true,
            'message' => 'Ok'
        ]);
    })->name('check.timeout');

    Route::name('user.')->prefix('account')->group(function () {
        Route::get('blog/get-all-posts', [User\BlogController::class, 'getAllPosts'])->name('blog.get-all-posts');
    });

    Route::prefix('v1')->as('v1.')->group(function () {
        Route::prefix('page/{page}')->group(function () {
            Route::get('/', [Api\PageApi::class, 'getPage'])->name('page.get');
        });

        Route::prefix('module/ecommerce')->group(function () {
            Route::get('categories', [Api\EcommerceApi::class, 'getEcommerceCategories'])->name('module.ecommerce.categories');
            Route::get('products', [Api\EcommerceApi::class, 'getEcommerceProducts'])->name('module.ecommerce.products');
            Route::get('/product/{product}', [Api\EcommerceApi::class, 'getProduct'])->name('module.ecommerce.product.get');

            Route::post('checkout', [Api\EcommerceApi::class, 'checkout'])->name('module.ecommerce.checkout');
            Route::post('checkout/success', [Api\EcommerceApi::class, 'checkoutSuccess'])->name('module.ecommerce.checkout.success');
        });

        Route::prefix('module/directory')->group(function () {
            Route::get('listings', [Api\DirectoryApi::class, 'getDirectoryListings'])->name('module.directory.listings');
        });

        Route::prefix('module/portfolio')->group(function () {
            Route::get('items', [Api\PortfolioApi::class, 'getPortfolioItems'])->name('module.portfolio.items');
        });
    });
});

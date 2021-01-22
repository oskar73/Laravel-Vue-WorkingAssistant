<?php

use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

Route::name('user.')->prefix('account')->middleware('auth', 'verified')->group(function () {
    Route::get('/todo', [User\TodoController::class, 'index'])->name('todo.index');
    Route::get('/getTodoCount', [User\TodoController::class, 'getTodoCount'])->name('todo.getTodoCount');
    Route::get('/todo/{type}', [User\TodoController::class, 'detail'])->name('todo.detail');

    Route::get('/dashboard', [User\DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('blog')->name('blog.')->middleware('module_publish:advanced_blog')->group(function () {
        Route::get('/', [User\BlogController::class, 'index'])->name('index');
        Route::get('create', [User\BlogController::class, 'create'])->name('create');
        Route::post('create', [User\BlogController::class, 'store'])->name('store');
        Route::get('detail/{slug}', [User\BlogController::class, 'detail'])->name('detail');
        Route::get('edit/{slug}', [User\BlogController::class, 'edit'])->name('edit');
        Route::post('edit/{slug}', [User\BlogController::class, 'update'])->name('update');
    });

    Route::prefix('blogAds')->name('blogAds.')->middleware('module_publish:blogAds')->group(function () {
        Route::get('/', [User\BlogAdsController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [User\BlogAdsController::class, 'detail'])->name('detail');
        Route::get('/edit/{id}', [User\BlogAdsController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [User\BlogAdsController::class, 'update'])->name('update');
        Route::get('/tracking/{id}', [User\BlogAdsController::class, 'tracking'])->name('tracking');
        Route::get('/getChart/{id}', [User\BlogAdsController::class, 'getChart'])->name('getChart');
    });

    Route::prefix('siteAds')->name('siteAds.')->middleware('module_publish:siteAds')->group(function () {
        Route::get('/', [User\SiteAdsController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [User\SiteAdsController::class, 'detail'])->name('detail');
        Route::get('/edit/{id}', [User\SiteAdsController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [User\SiteAdsController::class, 'update'])->name('update');
        Route::get('/tracking/{id}', [User\SiteAdsController::class, 'tracking'])->name('tracking');
        Route::get('/getChart/{id}', [User\SiteAdsController::class, 'getChart'])->name('getChart');
    });

    Route::prefix('directory')->name('directory.')->middleware('module_publish:directory')->group(function () {
        Route::get('/', [User\DirectoryController::class, 'index'])->name('index');
        Route::get('select', [User\DirectoryController::class, 'select'])->name('select');
        Route::get('/create/{id}', [User\DirectoryController::class, 'create'])->name('create');
        Route::post('create/{id}', [User\DirectoryController::class, 'store'])->name('store');
        Route::get('show/{slug}', [User\DirectoryController::class, 'show'])->name('show');
        Route::get('edit/{slug}', [User\DirectoryController::class, 'edit'])->name('edit');
        Route::post('edit/{slug}', [User\DirectoryController::class, 'update'])->name('update');
    });

    Route::prefix('directoryAds')->name('directoryAds.')->middleware('module_publish:directoryAds')->group(function () {
        Route::get('/', [User\DirectoryAdsController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [User\DirectoryAdsController::class, 'detail'])->name('detail');
        Route::get('/edit/{id}', [User\DirectoryAdsController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [User\DirectoryAdsController::class, 'update'])->name('update');
        Route::get('/tracking/{id}', [User\DirectoryAdsController::class, 'tracking'])->name('tracking');
        Route::get('/getChart/{id}', [User\DirectoryAdsController::class, 'getChart'])->name('getChart');
    });

    Route::prefix('ecommerce')->name('ecommerce.')->middleware('module_publish:ecommerce')->group(function () {
        Route::get('/', [User\EcommerceController::class, 'index'])->name('index');
        Route::get('detail/{id}', [User\EcommerceController::class, 'detail'])->name('detail');
        Route::get('edit/{slug}', [User\EcommerceController::class, 'edit'])->name('edit');
        Route::post('edit/{slug}', [User\EcommerceController::class, 'update'])->name('update');
    });
    Route::prefix('ticket')->name('ticket.')->middleware('module_publish:ticket')->group(function () {
        Route::get('/', [User\TicketController::class, 'index'])->name('index');
        Route::get('create', [User\TicketController::class, 'create'])->name('create');
        Route::post('create', [User\TicketController::class, 'store'])->name('store');
        Route::get('reply/{id}', [User\TicketController::class, 'edit'])->name('edit');
        Route::get('show/{id}', [User\TicketController::class, 'show'])->name('show');
        Route::post('reply/{id}', [User\TicketController::class, 'update'])->name('update');
        Route::get('switch', [User\TicketController::class, 'switch'])->name('switch');
    });
    Route::prefix('appointment')->name('appointment.')->middleware('module_publish:appointment')->group(function () {
        Route::get('/listing', [User\Appointment\ListingController::class, 'index'])->name('listing.index');
        Route::get('/listing/getData', [User\Appointment\ListingController::class, 'getData'])->name('listing.getData');
        Route::post('/listing/store', [User\Appointment\ListingController::class, 'store'])->name('listing.store');
        Route::get('/listing/detail/{id}', [User\Appointment\ListingController::class, 'detail'])->name('listing.detail');
        Route::get('/listing/edit/{id}', [User\Appointment\ListingController::class, 'edit'])->name('listing.edit');
        Route::post('/listing/approve/{id}', [User\Appointment\ListingController::class, 'update'])->name('listing.update');
        Route::get('/listing/switch', [User\Appointment\ListingController::class, 'switchListing'])->name('listing.switch');
    
        Route::get('/', [User\AppointmentController::class, 'index'])->name('index');
        Route::get('create', [User\AppointmentController::class, 'create'])->name('create');
        Route::get('detail/{id}', [User\AppointmentController::class, 'detail'])->name('detail');
        Route::get('edit/{id}', [User\AppointmentController::class, 'edit'])->name('edit');
        Route::get('cancel/{id}', [User\AppointmentController::class, 'cancel'])->name('cancel');
        Route::get('selectProduct', [User\AppointmentController::class, 'selectProduct'])->name('selectProduct');
        Route::get('selectCategory', [User\AppointmentController::class, 'selectCategory'])->name('selectCategory');
        Route::post('store', [User\AppointmentController::class, 'store'])->name('store');
    });

    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::get('order', [User\Purchase\OrderController::class, 'index'])->name('order.index');
        Route::get('order/detail/{id}', [User\Purchase\OrderController::class, 'detail'])->name('order.detail');

        Route::get('subscription', [User\Purchase\SubscriptionController::class, 'index'])->name('subscription.index');
        Route::get('subscription/detail/{id}', [User\Purchase\SubscriptionController::class, 'detail'])->name('subscription.detail');
        Route::post('subscription/cancel', [User\Purchase\SubscriptionController::class, 'cancel'])->name('subscription.cancel');

        Route::get('transaction', [User\Purchase\TransactionController::class, 'index'])->name('transaction.index');
        Route::get('transaction/invoice/{id}', [User\Purchase\TransactionController::class, 'invoice'])->name('transaction.invoice');
        Route::get('transaction/invoice/{id}/download', [User\Purchase\TransactionController::class, 'invoiceDownload'])->name('transaction.invoiceDownload');

        //Route::get('blog', 'ProductController@blog')->name('blog.index');
        //Route::get('blog/detail/{id}', 'ProductController@blogDetail')->name('blog.detail');

        Route::get('form', [User\Purchase\FormController::class, 'index'])->name('form.index');
        Route::get('form/detail/{id}', [User\Purchase\FormController::class, 'detail'])->name('form.detail');
        Route::get('form/edit/{id}', [User\Purchase\FormController::class, 'edit'])->name('form.edit');
        Route::post('form/edit/{id}', [User\Purchase\FormController::class, 'update'])->name('form.update');
        Route::get('form/switch', [User\Purchase\FormController::class, 'switchForm'])->name('form.switch');

        Route::get('product', [User\Purchase\ProductController::class, 'index'])->name('product.index');
        Route::get('product/detail/{id}', [User\Purchase\ProductController::class, 'detail'])->name('product.detail');
    });
});

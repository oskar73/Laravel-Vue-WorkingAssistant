<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::name('admin.')->prefix('admin')->middleware('auth', 'role:admin')->group(function () {
    Route::get('/todo', [Admin\TodoController::class, 'index'])->name('todo.index');
    Route::get('/getTodoCount', [Admin\TodoController::class, 'getTodoCount'])->name('todo.getTodoCount');
    Route::get('/todo/{type}', [Admin\TodoController::class, 'detail'])->name('todo.detail');

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/test/{type}', [Admin\DashboardController::class, 'test'])->name('test');
    Route::get('/selectUser', [Admin\DashboardController::class, 'selectUser'])->name('selectUser');
    Route::get('/dashboard/analytics', [Admin\DashboardController::class, 'analytics'])->name('analytics');

    Route::get('userManage', [Admin\UserManageController::class, 'index'])->name('userManage.index');
    Route::get('userManage/create', [Admin\UserManageController::class, 'create'])->name('userManage.create');
    Route::post('userManage/create', [Admin\UserManageController::class, 'store'])->name('userManage.store');
    Route::get('userManage/detail/{id}', [\App\Http\Controllers\Admin\UserManageController::class, 'detail'])->name('userManage.detail');
    Route::get('userManage/edit/{id}', [Admin\UserManageController::class, 'edit'])->name('userManage.edit');
    Route::post('userManage/updateProfile/{id}', [Admin\UserManageController::class, 'updateProfile'])->name('userManage.updateProfile');
    Route::post('userManage/updatePassword/{id}', [Admin\UserManageController::class, 'updatePassword'])->name('userManage.updatePassword');

    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('basic', [Admin\Setting\BasicController::class, 'index'])->name('basic.index');
        Route::post('basic', [Admin\Setting\BasicController::class, 'store'])->name('basic.store');

        Route::get('social', [Admin\Setting\SocialController::class, 'index'])->name('social.index');
        Route::post('social', [Admin\Setting\SocialController::class, 'store'])->name('social.store');

        Route::get('seo', [Admin\Setting\SeoController::class, 'index'])->name('seo.index');
        Route::post('seo', [Admin\Setting\SeoController::class, 'store'])->name('seo.store');
        Route::get('seo/generateSitemap', [Admin\Setting\SeoController::class, 'generateSitemap'])->name('seo.generateSitemap')->middleware('throttle:sitemap');
        Route::get('seo/downloadSitemap', [Admin\Setting\SeoController::class, 'downloadSitemap'])->name('seo.downloadSitemap')->middleware('throttle:sitemap');

        Route::get('script', [Admin\Setting\ScriptController::class, 'index'])->name('script.index');
        Route::post('script', [Admin\Setting\ScriptController::class, 'store'])->name('script.store');

        Route::get('analytics', [Admin\Setting\AnalyticsController::class, 'index'])->name('analytics.index');
        Route::post('analytics', [Admin\Setting\AnalyticsController::class, 'store'])->name('analytics.store');

        Route::get('color', [Admin\Setting\ColorController::class, 'index'])->name('color.index');
        Route::get('color/create/{type}', [Admin\Setting\ColorController::class, 'create'])->name('color.create');
        Route::post('color/create/{type}', [Admin\Setting\ColorController::class, 'store'])->name('color.store');
        Route::get('color/edit/{id}', [Admin\Setting\ColorController::class, 'edit'])->name('color.edit');
        Route::post('color/edit/{id}', [Admin\Setting\ColorController::class, 'update'])->name('color.update');
        Route::get('color/switchItem', [Admin\Setting\ColorController::class, 'switchItem'])->name('color.switchItem');

        Route::get('payment', [Admin\Setting\PaymentController::class, 'index'])
            ->name('payment.index')
            ->middleware('password.confirm');

        Route::post('payment', [Admin\Setting\PaymentController::class, 'store'])->name('payment.store');
    });

    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::get('order', [Admin\Purchase\OrderController::class, 'index'])->name('order.index');
        Route::get('order/detail/{id}', [Admin\Purchase\OrderController::class, 'detail'])->name('order.detail');

        Route::get('subscription', [Admin\Purchase\SubscriptionController::class, 'index'])->name('subscription.index');
        Route::get('subscription/detail/{id}', [Admin\Purchase\SubscriptionController::class, 'detail'])->name('subscription.detail');
        Route::post('subscription/cancel', [Admin\Purchase\SubscriptionController::class, 'cancel'])->name('subscription.cancel');

        Route::get('transaction', [Admin\Purchase\TransactionController::class, 'index'])->name('transaction.index');
        Route::get('transaction/invoice/{id}', [Admin\Purchase\TransactionController::class, 'invoice'])->name('transaction.invoice');
        Route::get('transaction/invoice/{id}/download', [Admin\Purchase\TransactionController::class, 'invoiceDownload'])->name('transaction.invoiceDownload');

        Route::get('form', [Admin\Purchase\FormController::class, 'index'])->name('form.index');
        Route::get('form/detail/{id}', [Admin\Purchase\FormController::class, 'detail'])->name('form.detail');
        Route::get('form/edit/{id}', [Admin\Purchase\FormController::class, 'edit'])->name('form.edit');
        Route::post('form/edit/{id}', [Admin\Purchase\FormController::class, 'update'])->name('form.update');
        Route::get('form/switch', [Admin\Purchase\FormController::class, 'switchForm'])->name('form.switch');

        Route::get('blog', [Admin\Purchase\ProductController::class, 'blog'])->name('blog.index');
        Route::get('blog/detail/{id}', [Admin\Purchase\ProductController::class, 'blogDetail'])->name('blog.detail');

        Route::get('directory', [Admin\Purchase\ProductController::class, 'directory'])->name('directory.index');
        Route::get('directory/detail/{id}', [Admin\Purchase\ProductController::class, 'directoryDetail'])->name('directory.detail');

        Route::get('ecommerce', [Admin\Purchase\ProductController::class, 'ecommerce'])->name('ecommerce.index');
        Route::get('ecommerce/detail/{id}', [Admin\Purchase\ProductController::class, 'ecommerceDetail'])->name('ecommerce.detail');
    });

    Route::prefix('purchasefollowup')->name('purchasefollowup.')->group(function () {
        Route::get('email', [Admin\PurchaseFollowup\EmailController::class, 'index'])->name('email.index');
        Route::post('email', [Admin\PurchaseFollowup\EmailController::class, 'store'])->name('email.store');
        Route::get('email/switch', [Admin\PurchaseFollowup\EmailController::class, 'switch'])->name('email.switch');

        Route::get('form', [Admin\PurchaseFollowup\FormController::class, 'index'])->name('form.index');
        Route::get('form/create', [Admin\PurchaseFollowup\FormController::class, 'create'])->name('form.create');
        Route::post('form/create', [Admin\PurchaseFollowup\FormController::class, 'store'])->name('form.store');
        Route::get('form/show/{id}', [Admin\PurchaseFollowup\FormController::class, 'show'])->name('form.show');
        Route::get('form/edit/{id}', [Admin\PurchaseFollowup\FormController::class, 'edit'])->name('form.edit');
        Route::get('form/switch', [Admin\PurchaseFollowup\FormController::class, 'switch'])->name('form.switch');
    });

//    Route::group(['prefix'=>'coupon', 'as'=>'coupon.'], function() {
//        Route::get('/', 'CouponController@index')->name('index');
//        Route::post('/', 'CouponController@store')->name('store');
//        Route::get('/product', 'CouponController@product')->name('product');
//        Route::get('/edit', 'CouponController@edit')->name('edit');
//        Route::get('/switch', 'CouponController@switch')->name('switch');
//    });

    Route::prefix('quick-tours')->name('quick-tours.')->group(function () {
        Route::get('/', [Admin\QuickTourController::class, 'index'])->name('index');
        Route::post('/', [Admin\QuickTourController::class, 'store'])->name('store');
        Route::get('/switch', [Admin\QuickTourController::class, 'switch'])->name('switch');
        Route::get('/sort', [Admin\QuickTourController::class, 'getSort'])->name('sort');
        Route::post('/sort', [Admin\QuickTourController::class, 'updateSort']);
        Route::get('/get-target-ids', [Admin\QuickTourController::class, 'getTargetIds'])->name('get-target-ids');
    });

    Route::prefix('blog')->name('blog.')->middleware('module_active:simple_blog|advanced_blog')->group(function () {
        Route::get('front', [Admin\Blog\FrontController::class, 'index'])->name('front.index');
        Route::post('front', [Admin\Blog\FrontController::class, 'store'])->name('front.store');

        Route::middleware('module_active:advanced_blog')->group(function () {
            Route::get('setting', [Admin\Blog\SettingController::class, 'index'])->name('setting.index');
            Route::post('setting', [Admin\Blog\SettingController::class, 'store'])->name('setting.store');

            Route::get('package', [Admin\Blog\PackageController::class, 'index'])->name('package.index');
            Route::get('package/switch', [Admin\Blog\PackageController::class, 'switch'])->name('package.switch');
            Route::get('package/sort', [Admin\Blog\PackageController::class, 'getSort'])->name('package.sort');
            Route::post('package/sort', [Admin\Blog\PackageController::class, 'updateSort']);

            Route::get('package/create', [Admin\Blog\PackageController::class, 'create'])->name('package.create');
            Route::post('package/create', [Admin\Blog\PackageController::class, 'store'])->name('package.store');
            Route::get('package/edit/{id}', [Admin\Blog\PackageController::class, 'edit'])->name('package.edit');
            Route::post('package/edit/{id}', [Admin\Blog\PackageController::class, 'update'])->name('package.update');

            Route::post('package/updateMeetingForm/{id}', [Admin\Blog\PackageController::class, 'updateMeetingForm'])->name('package.updateMeetingForm');
            Route::post('package/createPrice/{id}', [Admin\Blog\PackageController::class, 'createPrice'])->name('package.createPrice');
            Route::delete('package/deletePrice/{id}', [Admin\Blog\PackageController::class, 'deletePrice'])->name('package.deletePrice');

            Route::get('author', [Admin\Blog\AuthorController::class, 'index'])->name('author.index');
        });

        Route::get('category', [Admin\Blog\CategoryController::class, 'index'])->name('category.index');
        Route::post('category', [Admin\Blog\CategoryController::class, 'store'])->name('category.store');
        Route::get('category/switch', [Admin\Blog\CategoryController::class, 'switch'])->name('category.switch');
        Route::get('category/sort', [Admin\Blog\CategoryController::class, 'getSort'])->name('category.sort');
        Route::post('category/sort', [Admin\Blog\CategoryController::class, 'updateSort']);

        Route::get('tag', [Admin\Blog\TagController::class, 'index'])->name('tag.index');
        Route::post('tag', [Admin\Blog\TagController::class, 'store'])->name('tag.store');
        Route::get('tag/switch', [Admin\Blog\TagController::class, 'switch'])->name('tag.switch');

        Route::get('post', [Admin\Blog\PostController::class, 'index'])->name('post.index');
        Route::get('post/create', [Admin\Blog\PostController::class, 'create'])->name('post.create');
        Route::post('post/create', [Admin\Blog\PostController::class, 'store'])->name('post.store');
        Route::get('post/import', [Admin\Blog\PostController::class, 'importView'])->name('post.importView');
        Route::post('post/import/view', [Admin\Blog\PostController::class, 'importPageView'])->name('post.importPageView');
        Route::post('post/import', [Admin\Blog\PostController::class, 'import'])->name('post.import');
        Route::get('post/show/{id}', [Admin\Blog\PostController::class, 'show'])->name('post.show');
        Route::get('post/edit/{id}', [Admin\Blog\PostController::class, 'edit'])->name('post.edit');
        Route::post('post/edit/{id}', [Admin\Blog\PostController::class, 'update'])->name('post.update');
        Route::get('post/switchPost', [Admin\Blog\PostController::class, 'switchPost'])->name('post.switchPost');

        Route::get('comment', [Admin\Blog\CommentController::class, 'index'])->name('comment.index');
        Route::get('comment/show/{id}', [Admin\Blog\CommentController::class, 'show'])->name('comment.show');
        Route::get('comment/edit/{id}', [Admin\Blog\CommentController::class, 'edit'])->name('comment.edit');
        Route::post('comment/edit/{id}', [Admin\Blog\CommentController::class, 'update'])->name('comment.update');
        Route::get('comment/switchComment', [Admin\Blog\CommentController::class, 'switchComment'])->name('comment.switchComment');
    });

    Route::prefix('blogAds')->name('blogAds.')->middleware('module_active:blogAds')->group(function () {
        Route::get('front', [Admin\BlogAds\FrontController::class, 'index'])->name('front.index');
        Route::post('front', [Admin\BlogAds\FrontController::class, 'store'])->name('front.store');

        Route::get('type', [Admin\BlogAds\TypeController::class, 'index'])->name('type.index');
        Route::post('type', [Admin\BlogAds\TypeController::class, 'store'])->name('type.store');
        Route::get('type/switch', [Admin\BlogAds\TypeController::class, 'switch'])->name('type.switch');

        Route::get('position', [Admin\BlogAds\PositionController::class, 'index'])->name('position.index');
        Route::post('position', [Admin\BlogAds\PositionController::class, 'store'])->name('position.store');
        Route::get('position/switch', [Admin\BlogAds\PositionController::class, 'switchPosition'])->name('position.switch');

        Route::get('spot', [Admin\BlogAds\SpotController::class, 'index'])->name('spot.index');
        Route::get('spot/create', [Admin\BlogAds\SpotController::class, 'create'])->name('spot.create');
        Route::post('spot/create', [Admin\BlogAds\SpotController::class, 'store'])->name('spot.store');
        Route::get('spot/switch', [Admin\BlogAds\SpotController::class, 'switchSpot'])->name('spot.switch');
        Route::get('spot/getPosition', [Admin\BlogAds\SpotController::class, 'getPosition'])->name('spot.getPosition');
        Route::get('spot/edit/{id}', [Admin\BlogAds\SpotController::class, 'edit'])->name('spot.edit');
        Route::post('spot/edit/{id}', [Admin\BlogAds\SpotController::class, 'update'])->name('spot.update');
        Route::post('spot/createPrice/{id}', [Admin\BlogAds\SpotController::class, 'createPrice'])->name('spot.createPrice');
        Route::delete('spot/deletePrice/{id}', [Admin\BlogAds\SpotController::class, 'deletePrice'])->name('spot.deletePrice');
        Route::post('spot/updateListing/{id}', [Admin\BlogAds\SpotController::class, 'updateListing'])->name('spot.updateListing');

        Route::get('listing', [Admin\BlogAds\ListingController::class, 'index'])->name('listing.index');
        Route::get('listing/select', [Admin\BlogAds\ListingController::class, 'select'])->name('listing.select');
        Route::get('listing/create/{slug}', [Admin\BlogAds\ListingController::class, 'create'])->name('listing.create');
        Route::post('listing/create/{slug}', [Admin\BlogAds\ListingController::class, 'store'])->name('listing.store');
        Route::get('listing/show/{id}', [Admin\BlogAds\ListingController::class, 'show'])->name('listing.show');
        Route::get('listing/edit/{id}', [Admin\BlogAds\ListingController::class, 'edit'])->name('listing.edit');
        Route::post('listing/edit/{id}', [Admin\BlogAds\ListingController::class, 'update'])->name('listing.update');
        Route::get('listing/tracking/{id}', [Admin\BlogAds\ListingController::class, 'tracking'])->name('listing.tracking');
        Route::get('listing/getChart/{id}', [Admin\BlogAds\ListingController::class, 'getChart'])->name('listing.getChart');
        Route::post('listing/updateStatus/{id}', [Admin\BlogAds\ListingController::class, 'updateStatus'])->name('listing.updateStatus');
        Route::get('listing/switch', [Admin\BlogAds\ListingController::class, 'switchListing'])->name('listing.switch');

        Route::get('calendar', [Admin\BlogAds\CalendarController::class, 'index'])->name('calendar.index');
        Route::get('calendar/spot/{id}', [Admin\BlogAds\CalendarController::class, 'spot'])->name('calendar.spot');
        Route::get('calendar/events', [Admin\BlogAds\CalendarController::class, 'events'])->name('calendar.events');
    });

    Route::prefix('siteAds')->name('siteAds.')->middleware('module_active:siteAds')->group(function () {
        Route::get('front', [Admin\SiteAds\FrontController::class, 'index'])->name('front.index');
        Route::post('front', [Admin\SiteAds\FrontController::class, 'store'])->name('front.store');

        Route::get('type', [Admin\SiteAds\TypeController::class, 'index'])->name('type.index');
        Route::post('type', [Admin\SiteAds\TypeController::class, 'store'])->name('type.store');
        Route::get('type/switch', [Admin\SiteAds\TypeController::class, 'switch'])->name('type.switch');

        Route::get('spot', [Admin\SiteAds\SpotController::class, 'index'])->name('spot.index');
        Route::get('spot/page/{page_id}/{type_id}', [Admin\SiteAds\SpotController::class, 'page'])->name('spot.page');
        Route::get('spot/create/{page_id}/{type_id}', [Admin\SiteAds\SpotController::class, 'create'])->name('spot.create');
        Route::post('spot/create/{page_id}/{type_id}', [Admin\SiteAds\SpotController::class, 'store'])->name('spot.store');
        Route::get('spot/edit/{id}', [Admin\SiteAds\SpotController::class, 'edit'])->name('spot.edit');
        Route::post('spot/edit/{id}', [Admin\SiteAds\SpotController::class, 'update'])->name('spot.update');
        Route::get('spot/editPosition/{id}', [Admin\SiteAds\SpotController::class, 'editPosition'])->name('spot.editPosition');
        Route::post('spot/editPosition/{id}', [Admin\SiteAds\SpotController::class, 'updatePosition'])->name('spot.updatePosition');
        Route::post('spot/createPrice/{id}', [Admin\SiteAds\SpotController::class, 'createPrice'])->name('spot.createPrice');
        Route::delete('spot/deletePrice/{id}', [Admin\SiteAds\SpotController::class, 'deletePrice'])->name('spot.deletePrice');
        Route::post('spot/updateListing/{id}', [Admin\SiteAds\SpotController::class, 'updateListing'])->name('spot.updateListing');
        Route::get('spot/switchSpot', [Admin\SiteAds\SpotController::class, 'switchSpot'])->name('spot.switchSpot');
        Route::get('spot/getAds', [Admin\SiteAds\SpotController::class, 'getAds'])->name('spot.getAds');

        Route::get('listing', [Admin\SiteAds\ListingController::class, 'index'])->name('listing.index');
        Route::get('listing/select', [Admin\SiteAds\ListingController::class, 'select'])->name('listing.select');
        Route::get('listing/create/{slug}', [Admin\SiteAds\ListingController::class, 'create'])->name('listing.create');
        Route::post('listing/create/{slug}', [Admin\SiteAds\ListingController::class, 'store'])->name('listing.store');
        Route::get('listing/show/{id}', [Admin\SiteAds\ListingController::class, 'show'])->name('listing.show');
        Route::get('listing/edit/{id}', [Admin\SiteAds\ListingController::class, 'edit'])->name('listing.edit');
        Route::post('listing/edit/{id}', [Admin\SiteAds\ListingController::class, 'update'])->name('listing.update');
        Route::get('listing/tracking/{id}', [Admin\SiteAds\ListingController::class, 'tracking'])->name('listing.tracking');
        Route::get('listing/getChart/{id}', [Admin\SiteAds\ListingController::class, 'getChart'])->name('listing.getChart');
        Route::post('listing/updateStatus/{id}', [Admin\SiteAds\ListingController::class, 'updateStatus'])->name('listing.updateStatus');
        Route::get('listing/switch', [Admin\SiteAds\ListingController::class, 'switchListing'])->name('listing.switch');
    });

    Route::prefix('portfolio')->name('portfolio.')->middleware('module_active:portfolio')->group(function () {
        Route::get('front', [Admin\Portfolio\FrontController::class, 'index'])->name('front.index');
        Route::post('front', [Admin\Portfolio\FrontController::class, 'store'])->name('front.store');

        Route::get('category', [Admin\Portfolio\CategoryController::class, 'index'])->name('category.index');
        Route::post('category', [Admin\Portfolio\CategoryController::class, 'store'])->name('category.store');
        Route::get('category/switch', [Admin\Portfolio\CategoryController::class, 'switch'])->name('category.switch');
        Route::get('category/sort', [Admin\Portfolio\CategoryController::class, 'getSort'])->name('category.sort');
        Route::post('category/sort', [Admin\Portfolio\CategoryController::class, 'updateSort']);

        Route::get('item', [Admin\Portfolio\ItemController::class, 'index'])->name('item.index');
        Route::get('item/create', [Admin\Portfolio\ItemController::class, 'create'])->name('item.create');
        Route::post('item/create', [Admin\Portfolio\ItemController::class, 'store'])->name('item.store');
        Route::get('item/edit/{id}', [Admin\Portfolio\ItemController::class, 'edit'])->name('item.edit');
        Route::post('item/edit/{id}', [Admin\Portfolio\ItemController::class, 'update'])->name('item.update');
        Route::get('item/switch', [Admin\Portfolio\ItemController::class, 'switch'])->name('item.switch');
    });

    Route::prefix('directory')->name('directory.')->middleware('module_active:directory')->group(function () {
        Route::get('front', [Admin\Directory\FrontController::class, 'index'])->name('front.index');
        Route::post('front', [Admin\Directory\FrontController::class, 'store'])->name('front.store');

        Route::get('setting', [Admin\Directory\SettingController::class, 'index'])->name('setting.index');
        Route::post('setting', [Admin\Directory\SettingController::class, 'store'])->name('setting.store');

        Route::get('category', [Admin\Directory\CategoryController::class, 'index'])->name('category.index');
        Route::post('category', [Admin\Directory\CategoryController::class, 'store'])->name('category.store');
        Route::get('category/switch', [Admin\Directory\CategoryController::class, 'switch'])->name('category.switch');
        Route::get('category/sort', [Admin\Directory\CategoryController::class, 'getSort'])->name('category.sort');
        Route::post('category/sort', [Admin\Directory\CategoryController::class, 'updateSort']);

        Route::get('tag', [Admin\Directory\TagController::class, 'index'])->name('tag.index');
        Route::post('tag', [Admin\Directory\TagController::class, 'store'])->name('tag.store');
        Route::get('tag/switch', [Admin\Directory\TagController::class, 'switch'])->name('tag.switch');

        Route::get('package', [Admin\Directory\PackageController::class, 'index'])->name('package.index');
        Route::get('package/switch', [Admin\Directory\PackageController::class, 'switch'])->name('package.switch');
        Route::get('package/sort', [Admin\Directory\PackageController::class, 'getSort'])->name('package.sort');
        Route::post('package/sort', [Admin\Directory\PackageController::class, 'updateSort']);

        Route::get('package/create', [Admin\Directory\PackageController::class, 'create'])->name('package.create');
        Route::post('package/create', [Admin\Directory\PackageController::class, 'store'])->name('package.store');
        Route::get('package/edit/{id}', [Admin\Directory\PackageController::class, 'edit'])->name('package.edit');
        Route::post('package/edit/{id}', [Admin\Directory\PackageController::class, 'update'])->name('package.update');

        Route::post('package/updateMeetingForm/{id}', [Admin\Directory\PackageController::class, 'updateMeetingForm'])->name('package.updateMeetingForm');
        Route::post('package/createPrice/{id}', [Admin\Directory\PackageController::class, 'createPrice'])->name('package.createPrice');
        Route::delete('package/deletePrice/{id}', [Admin\Directory\PackageController::class, 'deletePrice'])->name('package.deletePrice');

        Route::get('listing', [Admin\Directory\ListingController::class, 'index'])->name('listing.index');
        Route::get('listing/create', [Admin\Directory\ListingController::class, 'create'])->name('listing.create');
        Route::post('listing/create', [Admin\Directory\ListingController::class, 'store'])->name('listing.store');
        Route::get('listing/show/{id}', [Admin\Directory\ListingController::class, 'edit'])->name('listing.show');
        Route::get('listing/edit/{id}', [Admin\Directory\ListingController::class, 'edit'])->name('listing.edit');

        Route::get('listing/switch', [Admin\Directory\ListingController::class, 'switch'])->name('listing.switch');
    });

    Route::prefix('directoryAds')->name('directoryAds.')->middleware('module_active:directoryAds')->group(function () {
        Route::get('front', [Admin\DirectoryAds\FrontController::class, 'index'])->name('front.index');
        Route::post('front', [Admin\DirectoryAds\FrontController::class, 'store'])->name('front.store');

        Route::get('type', [Admin\DirectoryAds\TypeController::class, 'index'])->name('type.index');
        Route::post('type', [Admin\DirectoryAds\TypeController::class, 'store'])->name('type.store');
        Route::get('type/switch', [Admin\DirectoryAds\TypeController::class, 'switch'])->name('type.switch');

        Route::get('position', [Admin\DirectoryAds\PositionController::class, 'index'])->name('position.index');
        Route::post('position', [Admin\DirectoryAds\PositionController::class, 'store'])->name('position.store');
        Route::get('position/switch', [Admin\DirectoryAds\PositionController::class, 'switchPosition'])->name('position.switch');

        Route::get('spot', [Admin\DirectoryAds\SpotController::class, 'index'])->name('spot.index');
        Route::get('spot/create', [Admin\DirectoryAds\SpotController::class, 'create'])->name('spot.create');
        Route::post('spot/create', [Admin\DirectoryAds\SpotController::class, 'store'])->name('spot.store');
        Route::get('spot/switch', [Admin\DirectoryAds\SpotController::class, 'switchSpot'])->name('spot.switch');
        Route::get('spot/getPosition', [Admin\DirectoryAds\SpotController::class, 'getPosition'])->name('spot.getPosition');
        Route::get('spot/edit/{id}', [Admin\DirectoryAds\SpotController::class, 'edit'])->name('spot.edit');
        Route::post('spot/edit/{id}', [Admin\DirectoryAds\SpotController::class, 'update'])->name('spot.update');
        Route::post('spot/createPrice/{id}', [Admin\DirectoryAds\SpotController::class, 'createPrice'])->name('spot.createPrice');
        Route::delete('spot/deletePrice/{id}', [Admin\DirectoryAds\SpotController::class, 'deletePrice'])->name('spot.deletePrice');
        Route::post('spot/updateListing/{id}', [Admin\DirectoryAds\SpotController::class, 'updateListing'])->name('spot.updateListing');

        Route::get('listing', [Admin\DirectoryAds\ListingController::class, 'index'])->name('listing.index');
        Route::get('listing/select', [Admin\DirectoryAds\ListingController::class, 'select'])->name('listing.select');
        Route::get('listing/create/{slug}', [Admin\DirectoryAds\ListingController::class, 'create'])->name('listing.create');
        Route::post('listing/create/{slug}', [Admin\DirectoryAds\ListingController::class, 'store'])->name('listing.store');
        Route::get('listing/show/{id}', [Admin\DirectoryAds\ListingController::class, 'show'])->name('listing.show');
        Route::get('listing/edit/{id}', [Admin\DirectoryAds\ListingController::class, 'edit'])->name('listing.edit');
        Route::post('listing/edit/{id}', [Admin\DirectoryAds\ListingController::class, 'update'])->name('listing.update');
        Route::get('listing/tracking/{id}', [Admin\DirectoryAds\ListingController::class, 'tracking'])->name('listing.tracking');
        Route::get('listing/getChart/{id}', [Admin\DirectoryAds\ListingController::class, 'getChart'])->name('listing.getChart');
        Route::post('listing/updateStatus/{id}', [Admin\DirectoryAds\ListingController::class, 'updateStatus'])->name('listing.updateStatus');
        Route::get('listing/switch', [Admin\DirectoryAds\ListingController::class, 'switchListing'])->name('listing.switch');
    });

    Route::prefix('ecommerce')->name('ecommerce.')->middleware('module_active:ecommerce')->group(function () {
        Route::get('front', [Admin\Ecommerce\FrontController::class, 'index'])->name('front.index');
        Route::post('front', [Admin\Ecommerce\FrontController::class, 'store'])->name('front.store');

        Route::get('category', [Admin\Ecommerce\CategoryController::class, 'index'])->name('category.index');
        Route::post('category', [Admin\Ecommerce\CategoryController::class, 'store'])->name('category.store');
        Route::get('category/switch', [Admin\Ecommerce\CategoryController::class, 'switch'])->name('category.switch');
        Route::get('category/sort', [Admin\Ecommerce\CategoryController::class, 'getSort'])->name('category.sort');
        Route::post('category/sort', [Admin\Ecommerce\CategoryController::class, 'updateSort']);

        Route::get('product', [Admin\Ecommerce\ProductController::class, 'index'])->name('product.index');
        Route::get('product/create', [Admin\Ecommerce\ProductController::class, 'create'])->name('product.create');
        Route::post('product/create', [Admin\Ecommerce\ProductController::class, 'store'])->name('product.store');
        Route::get('product/edit/{id}', [Admin\Ecommerce\ProductController::class, 'edit'])->name('product.edit');
        Route::post('product/updateProduct/{id}', [Admin\Ecommerce\ProductController::class, 'updateProduct'])->name('product.updateProduct');
        Route::get('product/getPrice/{id}', [Admin\Ecommerce\ProductController::class, 'getPrice'])->name('product.getPrice');
        Route::post('product/createPrice/{id}', [Admin\Ecommerce\ProductController::class, 'createPrice'])->name('product.createPrice');
        Route::post('product/updatePrice/{id}', [Admin\Ecommerce\ProductController::class, 'updatePrice'])->name('product.updatePrice');
        Route::delete('product/delPrice/{id}', [Admin\Ecommerce\ProductController::class, 'delPrice'])->name('product.delPrice');
        Route::get('product/switch', [Admin\Ecommerce\ProductController::class, 'switch'])->name('product.switch');

        Route::get('customer', [Admin\Ecommerce\CustomerController::class, 'index'])->name('customer.index');
        Route::get('customer/switch', [Admin\Ecommerce\CustomerController::class, 'switch'])->name('customer.switch');

        Route::get('order', [Admin\Ecommerce\OrderController::class, 'index'])->name('order.index');
        Route::get('order/switch', [Admin\Ecommerce\OrderController::class, 'switch'])->name('order.switch');

        Route::get('payment', [Admin\Ecommerce\PaymentController::class, 'index'])->name('payment.index');
        Route::post('payment/withdraw', [Admin\Ecommerce\PaymentController::class, 'withdraw'])->name('payment.withdraw');

        Route::get('setting', [Admin\Ecommerce\SettingController::class, 'index'])->name('setting.index');
        Route::post('setting/account/link', [Admin\Ecommerce\SettingController::class, 'accountLink'])->name('setting.account.link');
        Route::post('setting/account/login', [Admin\Ecommerce\SettingController::class, 'accountLogin'])->name('setting.account.login');
        Route::get('setting/account/paypal/connect', [Admin\Ecommerce\SettingController::class, 'accountPaypalConnect'])->name('setting.account.paypal.connect');
    });
    Route::prefix('email')->name('email.')->middleware('module_active:email')->group(function () {
        Route::get('category', [Admin\Email\CategoryController::class, 'index'])->name('category.index');
        Route::post('category', [Admin\Email\CategoryController::class, 'store'])->name('category.store');
        Route::get('category/switch', [Admin\Email\CategoryController::class, 'switch'])->name('category.switch');
        Route::get('category/sort', [Admin\Email\CategoryController::class, 'getSort'])->name('category.sort');
        Route::post('category/sort', [Admin\Email\CategoryController::class, 'updateSort']);

        Route::get('/template', [Admin\Email\TemplateController::class, 'index'])->name('template.index');
        Route::get('/template/onlineTemplate', [Admin\Email\TemplateController::class, 'onlineTemplate'])->name('template.onlineTemplate');
        Route::get('/template/create', [Admin\Email\TemplateController::class, 'create'])->name('template.create');
        Route::post('/template/create', [Admin\Email\TemplateController::class, 'store'])->name('template.store');
        Route::get('/template/edit/{id}', [Admin\Email\TemplateController::class, 'edit'])->name('template.edit');
        Route::get('/template/show/{id}', [Admin\Email\TemplateController::class, 'show'])->name('template.show');
        Route::post('/template/updateBody/{id}', [Admin\Email\TemplateController::class, 'updateBody'])->name('template.updateBody');
        Route::get('/template/switch', [Admin\Email\TemplateController::class, 'switch'])->name('template.switch');
        Route::get('/template/viewOnlineTemplate/{slug}', [Admin\Email\TemplateController::class, 'viewOnlineTemplate'])->name('template.viewOnlineTemplate');
        Route::post('/template/saveOnlineTemplate', [Admin\Email\TemplateController::class, 'saveOnlineTemplate'])->name('template.saveOnlineTemplate');

        Route::get('/campaign', [Admin\Email\CampaignController::class, 'index'])->name('campaign.index');
        Route::get('/campaign/create', [Admin\Email\CampaignController::class, 'create'])->name('campaign.create');
        Route::post('/campaign/create', [Admin\Email\CampaignController::class, 'store'])->name('campaign.store');
        Route::get('/campaign/edit/{id}', [Admin\Email\CampaignController::class, 'edit'])->name('campaign.edit');
        Route::get('/campaign/show/{id}', [Admin\Email\CampaignController::class, 'show'])->name('campaign.show');
        Route::get('/campaign/switch', [Admin\Email\CampaignController::class, 'switch'])->name('campaign.switch');
        Route::get('/campaign/sendNow', [Admin\Email\CampaignController::class, 'sendNow'])->name('campaign.sendNow');
        Route::get('/campaign/getCategory', [Admin\Email\CampaignController::class, 'getCategory'])->name('campaign.getCategory');
        Route::get('/campaign/getTemplate', [Admin\Email\CampaignController::class, 'getTemplate'])->name('campaign.getTemplate');

        Route::get('subscriber', [Admin\Email\SubscriberController::class, 'index'])->name('subscriber.index');
        Route::get('subscriber/switch', [Admin\Email\SubscriberController::class, 'switch'])->name('subscriber.switch');
    });

    Route::prefix('appointment')->name('appointment.')->middleware('module_active:appointment')->group(function () {
        // comment out with version upgrade.
        Route::get('setting', [Admin\Appointment\SettingController::class, 'index'])->name('setting.index');
        Route::post('setting', [Admin\Appointment\SettingController::class, 'store'])->name('setting.store');

        Route::get('category', [Admin\Appointment\CategoryController::class, 'index'])->name('category.index');
        Route::get('category/create', [Admin\Appointment\CategoryController::class, 'create'])->name('category.create');
        Route::post('category/create', [Admin\Appointment\CategoryController::class, 'store'])->name('category.store');
        Route::get('category/edit/{id}', [Admin\Appointment\CategoryController::class, 'edit'])->name('category.edit');
        Route::post('category/edit/{id}', [Admin\Appointment\CategoryController::class, 'update'])->name('category.update');
        Route::get('category/switch', [Admin\Appointment\CategoryController::class, 'switch'])->name('category.switch');
        Route::get('category/sort', [Admin\Appointment\CategoryController::class, 'getSort'])->name('category.sort');
        Route::post('category/sort', [Admin\Appointment\CategoryController::class, 'updateSort']);

        Route::get('unavailable-dates/{type}/{id}', [Admin\Appointment\BlockDateController::class, 'index'])->name('blockDate.index');
        Route::get('unavailable-dates/edit/{type}/{id}', [Admin\Appointment\BlockDateController::class, 'edit'])->name('blockDate.edit');
        Route::post('unavailable-dates/{type}/{id}', [Admin\Appointment\BlockDateController::class, 'store'])->name('blockDate.store');
        Route::post('unavailable-dates/delete/{type}/{id}', [Admin\Appointment\BlockDateController::class, 'delete'])->name('blockDate.delete');

        Route::get('/listing', [Admin\Appointment\Own\ListingController::class, 'index'])->name('listing.index');
        Route::get('/listing/getData', [Admin\Appointment\Own\ListingController::class, 'getData'])->name('listing.getData');
        Route::get('/listing/edit/{id}', [Admin\Appointment\Own\ListingController::class, 'edit'])->name('listing.edit');
        Route::post('/listing/store', [Admin\Appointment\Own\ListingController::class, 'store'])->name('listing.store');
        Route::post('/listing/approve/{id}', [Admin\Appointment\Own\ListingController::class, 'update'])->name('listing.update');
        Route::get('/listing/detail/{id}', [Admin\Appointment\Own\ListingController::class, 'detail'])->name('listing.detail');
        Route::get('/listing/switch', [Admin\Appointment\Own\ListingController::class, 'switchListing'])->name('listing.switch');
        Route::get('/listing/allListing', [Admin\Appointment\Own\ListingController::class, 'allListing'])->name('listing.allListing');
    });

    Route::prefix('content')->name('content.')->group(function () {
        Route::prefix('review')->name('review.')->middleware('module_active:review')->group(function () {
            Route::get('/', [Admin\Content\ReviewController::class, 'index'])->name('index');
            Route::get('/show/{id}', [Admin\Content\ReviewController::class, 'show'])->name('show');
            Route::get('/edit', [Admin\Content\ReviewController::class, 'edit'])->name('edit');
            Route::post('/edit', [Admin\Content\ReviewController::class, 'update'])->name('update');
            Route::get('/switch', [Admin\Content\ReviewController::class, 'switch'])->name('switch');
        });

        Route::prefix('page')->name('page.')->group(function () {
            Route::get('/', [Admin\Content\PageController::class, 'index'])->name('index');
            Route::get('/create', [Admin\Content\PageController::class, 'create'])->name('create');
            Route::post('/create', [Admin\Content\PageController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [Admin\Content\PageController::class, 'edit'])->name('edit');
            Route::post('/edit/{id}', [Admin\Content\PageController::class, 'update'])->name('update');
            Route::get('/editContent/{id}/{type}', [Admin\Content\PageController::class, 'editContent'])->name('editContent');
            Route::post('/editContent/{id}/{type}', [Admin\Content\PageController::class, 'updateContent'])->name('updateContent');
            Route::get('/switch', [Admin\Content\PageController::class, 'switch'])->name('switch');

            Route::post('/upload/cover/{page_id}', [Admin\Content\UploadController::class, 'uploadCover'])->name('uploadCover')->middleware('storage_check');
            Route::post('/upload/largeImage/{page_id}', [Admin\Content\UploadController::class, 'uploadLarageImage'])->name('largeImage')->middleware('storage_check');
            Route::post('/upload/moduleImage/{page_id}', [Admin\Content\UploadController::class, 'uploadModuleImage'])->name('moduleImage')->middleware('storage_check');
            Route::post('/upload/moduleVideo/{page_id}', [Admin\Content\UploadController::class, 'uploadModuleVideo'])->name('moduleVideo')->middleware('storage_check');
            Route::post('/upload/saveImage/{page_id}', [Admin\Content\UploadController::class, 'storeImage'])->name('saveImage')->middleware('storage_check');
        });
        Route::prefix('legalPage')->name('legalPage.')->group(function () {
            Route::get('/', [Admin\Content\LegalPageController::class, 'index'])->name('index');
            Route::get('/edit/{id}', [Admin\Content\LegalPageController::class, 'edit'])->name('edit');
            Route::post('/edit/{id}', [Admin\Content\LegalPageController::class, 'update'])->name('update');
        });
        Route::prefix('header')->name('header.')->group(function () {
            Route::get('/', [Admin\Content\HeaderController::class, 'index'])->name('index');
            Route::post('/store', [Admin\Content\HeaderController::class, 'store'])->name('store');
            Route::get('/edit', [Admin\Content\HeaderController::class, 'edit'])->name('edit');
            Route::delete('/delete', [Admin\Content\HeaderController::class, 'delete'])->name('delete');
            Route::get('/switchItem', [Admin\Content\HeaderController::class, 'switchItem'])->name('switchItem');
            Route::get('/updateOrder', [Admin\Content\HeaderController::class, 'updateOrder'])->name('updateOrder');
        });
        Route::prefix('footer')->name('footer.')->group(function () {
            Route::get('/', [Admin\Content\FooterController::class, 'index'])->name('index');
            Route::post('/store', [Admin\Content\FooterController::class, 'store'])->name('store');
            Route::get('/edit', [Admin\Content\FooterController::class, 'edit'])->name('edit');
            Route::delete('/delete', [Admin\Content\FooterController::class, 'delete'])->name('delete');
            Route::get('/switchItem', [Admin\Content\FooterController::class, 'switchItem'])->name('switchItem');
            Route::get('/updateOrder', [Admin\Content\FooterController::class, 'updateOrder'])->name('updateOrder');
        });
    });

    Route::prefix('ticket')->name('ticket.')->group(function () {
        Route::get('category', [Admin\Ticket\CategoryController::class, 'index'])->name('category.index');
        Route::post('category', [Admin\Ticket\CategoryController::class, 'store'])->name('category.store');
        Route::get('category/switch', [Admin\Ticket\CategoryController::class, 'switch'])->name('category.switch');
        Route::get('category/sort', [Admin\Ticket\CategoryController::class, 'getSort'])->name('category.sort');
        Route::post('category/sort', [Admin\Ticket\CategoryController::class, 'updateSort']);

        Route::get('item', [Admin\Ticket\ItemController::class, 'index'])->name('item.index');
        Route::get('item/reply/{id}', [Admin\Ticket\ItemController::class, 'edit'])->name('item.edit');
        Route::get('item/show/{id}', [Admin\Ticket\ItemController::class, 'show'])->name('item.show');
        Route::post('item/reply/{id}', [Admin\Ticket\ItemController::class, 'update'])->name('item.update');
        Route::get('item/switch', [Admin\Ticket\ItemController::class, 'switchTicket'])->name('item.switch');
    });

    Route::prefix('storage')->name('storage.')->group(function () {
        Route::get('/', [Admin\StorageController::class, 'index'])->name('index');
        Route::get('/getFrame', [Admin\StorageController::class, 'getFrame'])->name('getFrame');
        Route::get('/loadSize', [Admin\StorageController::class, 'loadSize'])->name('loadSize');
    });
    Route::prefix('module')->name('module.')->group(function () {
        Route::get('/', [Admin\ModuleController::class, 'index'])->name('index');
        Route::get('/getAllModules', [Admin\ModuleController::class, 'getAllModules'])->name('getAllModules');
        Route::get('/getMyModules', [Admin\ModuleController::class, 'getMyModules'])->name('getMyModules');
        Route::get('/getModule', [Admin\ModuleController::class, 'getModule'])->name('getModule');
        Route::get('/switchModule', [Admin\ModuleController::class, 'switchModule'])->name('switchModule');
    });

    Route::prefix('notification')->name('notification.')->group(function () {
        Route::get('template', [Admin\Notification\TemplateController::class, 'index'])->name('template.index');
        Route::get('template/create', [Admin\Notification\TemplateController::class, 'create'])->name('template.create');
        Route::post('template/create', [Admin\Notification\TemplateController::class, 'store'])->name('template.store');
        Route::get('template/edit/{id}', [Admin\Notification\TemplateController::class, 'edit'])->name('template.edit');
        Route::get('template/show/{id}', [Admin\Notification\TemplateController::class, 'show'])->name('template.show');
        Route::get('template/switch', [Admin\Notification\TemplateController::class, 'switch'])->name('template.switch');
    });

    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [Admin\Contacts\ContactsController::class, 'index'])->name('index');
        Route::get('/get', [Admin\Contacts\ContactsController::class, 'getContacts'])->name('getContacts');
        Route::get('/detail/{id}', [Admin\Contacts\ContactsController::class, 'detail'])->name('detail');
        Route::delete('/delete/{id}', [Admin\Contacts\ContactsController::class, 'delete'])->name('delete');
    }); 
});

                                                                      
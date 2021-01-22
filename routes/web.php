<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Front as Front;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;
use Illuminate\Support\Facades\Auth as AppAuth;

AppAuth::routes(['verify' => true]);

Route::get('/uploads/{disk}/{path}', [FileController::class, 'get'])->where('path', '(.*)')->name('file.get');
Route::get('/sitemap.xml', [FileController::class, 'sitemap'])->name('sitemap.get');

Route::get('/cart', [Front\CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [Front\CartController::class, 'update'])->name('cart.update');
Route::get('/cart/getData', [Front\CartController::class, 'getData'])->name('cart.getData');
Route::get('/cart/remove', [Front\CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/empty', [Front\CartController::class, 'empty'])->name('cart.empty');
Route::get('/cart/checkout', [Front\CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/checkout', [Front\CartController::class, 'checkoutCart'])->name('cart.checkout.items');

Route::get('/cart/login', [Front\PaymentController::class, 'login'])->name('cart.login');
Route::post('/cart/paypal/getUrl', [Front\PaymentController::class, 'paypalGetUrl'])->name('cart.paypal.getUrl')
    ->middleware(ProtectAgainstSpam::class);
Route::get('/cart/paypal/execute', [Front\PaymentController::class, 'paypalExecute'])->name('cart.paypal.execute');
Route::post('/cart/stripe/execute', [Front\PaymentController::class, 'stripeExecute'])->name('cart.stripe.execute')
    ->middleware(ProtectAgainstSpam::class);

Route::get('auth/{provider}', [Auth\SocialController::class, 'redirectToProvider'])->name('social.login');
Route::get('auth/{provider}/callback', [Auth\SocialController::class, 'handleProviderCallback'])->name('social.redirect');

Route::get('/home', [HomeController::class, 'index'])->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/{role}/profile', [HomeController::class, 'profile'])->name('profile');
    Route::get('/{role}/subscribed', [HomeController::class, 'subscribed'])->name('subscribed');
    Route::post('/{role}/subscribed', [HomeController::class, 'subscribedUpdate'])->name('subscribed.update')->middleware(ProtectAgainstSpam::class);
    Route::get('/{role}/subscribed/switch', [HomeController::class, 'subscribedSwitch'])->name('subscribed.switch');
    Route::post('/account/profileUpdate', [HomeController::class, 'profileUpdate'])->name('account.profile.update');
    Route::post('/account/passwordUpdate', [HomeController::class, 'passwordUpdate'])->name('account.password.update');
    Route::get('/{role}/notifications', [HomeController::class, 'notifications'])->name('notification');
    Route::get('/{role}/notifications/{id}/detail', [HomeController::class, 'notificationDetail'])->name('notification.detail');
    Route::get('/{role}/notifications/switch', [HomeController::class, 'notificationSwitch'])->name('notification.switch');

    Route::post('/uploadImage/{folder?}', [HomeController::class, 'uploadImage'])->name('uploadImage');
    Route::post('/uploadImages/{id}', [HomeController::class, 'uploadImages'])->name('uloapdImages');
});

Route::middleware('module_publish:email')->group(function () {
    Route::get('/getSubscribeForm', [Front\HomeController::class, 'getSubscribeForm'])->name('getSubscribeForm');
    Route::get('/closeSubscribeForm', [Front\HomeController::class, 'closeSubscribeForm'])->name('closeSubscribeForm');
    Route::post('/subscribe', [Front\HomeController::class, 'subscribe'])->name('subscribe')->middleware(ProtectAgainstSpam::class);
    Route::get('/subscribe/{token}', [Front\HomeController::class, 'subscribeConfirm'])->name('subscribe.confirm');
});

Route::get('/unsubscribe', [Front\HomeController::class, 'unsubscribe'])->name('unsubscribe');
Route::post('/unsubscribe', [Front\HomeController::class, 'unsubscribeConfirm'])->name('unsubscribe.confirm')->middleware(ProtectAgainstSpam::class);
Route::get('/mail/{id}', [Front\HomeController::class, 'mail'])->name('mail.view');

Route::middleware('module_publish:blogAds')->name('blogAds.')->prefix(config('custom.route.blogAds'))->group(function () {
    Route::get('/', [Front\BlogAdsController::class, 'index'])->name('index');
    Route::post('/getData', [Front\BlogAdsController::class, 'getData'])->name('getData');
    Route::post('/addtocart/{id}', [Front\BlogAdsController::class, 'addtocart'])->name('addtocart');
    Route::get('/spot/{slug}', [Front\BlogAdsController::class, 'spot'])->name('spot');
    Route::post('/impClick', [Front\BlogAdsController::class, 'impClick'])->name('impClick');
});
Route::middleware('module_publish:siteAds')->name('siteAds.')->prefix(config('custom.route.siteAds'))->group(function () {
    Route::get('/', [Front\SiteAdsController::class, 'index'])->name('index');
    Route::post('/getData', [Front\SiteAdsController::class, 'getData'])->name('getData');
    Route::post('/addtocart/{id}', [Front\SiteAdsController::class, 'addtocart'])->name('addtocart');
    Route::get('/spot/{slug}', [Front\SiteAdsController::class, 'spot'])->name('spot');
    Route::post('/impClick', [Front\SiteAdsController::class, 'impClick'])->name('impClick');
});
Route::middleware('module_publish:portfolio')->name('portfolio.')->prefix(config('custom.route.portfolio'))->group(function () {
    Route::get('/', [Front\PortfolioController::class, 'index'])->name('index');
    Route::get('/{slug}', [Front\PortfolioController::class, 'detail'])->name('detail');
});

Route::middleware('module_publish:ecommerce')->name('ecommerce.')->prefix(config('custom.route.ecommerce'))->group(function () {
   Route::get('/', [Front\EcommerceController::class, 'index'])->name('index');
   Route::get('/{slug}', [Front\EcommerceController::class, 'detail'])->name('detail');
   Route::get('/{slug}/addtocart', [Front\EcommerceController::class, 'addtocart'])->name('addtocart');
});

Route::name('product.')->prefix(config('custom.route.product'))->group(function () {
   Route::get('/', [Front\ProductController::class, 'index'])->name('index');
   Route::get('/{id}', [Front\ProductController::class, 'detail'])->name('detail');
   Route::get('/{id}/addtocart', [Front\ProductController::class, 'addtocart'])->name('addtocart');
});

Route::middleware('module_publish:directory')->name('directory.')->prefix(config('custom.route.directory'))->group(function () {
    Route::get('/', [Front\DirectoryController::class, 'index'])->name('index');
    Route::get('/category/{slug}', [Front\DirectoryController::class, 'category'])->name('category');
    Route::get('/category/{category}/{subCategory}', [Front\DirectoryController::class, 'subCategory'])->name('subCategory');
    Route::get('/tag/{slug}', [Front\DirectoryController::class, 'tag'])->name('tag');
    Route::get('/detail/{slug}', [Front\DirectoryController::class, 'detail'])->name('detail');
    Route::get('/packages', [Front\DirectoryController::class, 'package'])->name('package');
    Route::get('/packages/{slug}', [Front\DirectoryController::class, 'packageDetail'])->name('package.detail');
    Route::get('/packages/{id}/addtocart', [Front\DirectoryController::class, 'addtocart'])->name('package.addtocart');
});
Route::middleware('module_publish:directoryAds')->name('directoryAds.')->prefix(config('custom.route.directoryAds'))->group(function () {
    Route::get('/', [Front\DirectoryAdsController::class, 'index'])->name('index');
    Route::post('/getData', [Front\DirectoryAdsController::class, 'getData'])->name('getData');
    Route::post('/addtocart/{id}', [Front\DirectoryAdsController::class, 'addtocart'])->name('addtocart');
    Route::get('/spot/{slug}', [Front\DirectoryAdsController::class, 'spot'])->name('spot');
    Route::post('/impClick', [Front\DirectoryAdsController::class, 'impClick'])->name('impClick');
});
Route::middleware('module_publish:review')->name('review.')->prefix(config('custom.route.review'))->group(function () {
    Route::get('/', [Front\ReviewController::class, 'index'])->name('index');
    Route::post('/', [Front\ReviewController::class, 'store'])->name('store')->middleware(ProtectAgainstSpam::class);
});

Route::get('/getWebsiteData', [Front\PageController::class, 'getWebsiteData'])->where('url', '([A-Za-z0-9\-\/]+)')->name('get-website-data');

Route::middleware('module_publish:simple_blog|advanced_blog')->name('blog.')->prefix(config('custom.route.blog'))->group(function () {
    Route::get('/', [Front\BlogController::class, 'index'])->name('index');
    Route::get('/ajaxPage', [Front\BlogController::class, 'ajaxPage'])->name('ajaxPage');
    Route::get('/ajaxCategory/{id}', [Front\BlogController::class, 'ajaxCategory'])->name('ajaxCategory');
    Route::get('/ajaxTag/{id}', [Front\BlogController::class, 'ajaxTag'])->name('ajaxTag');
    Route::get('/ajaxAuthor/{username}', [Front\BlogController::class, 'ajaxAuthor'])->name('ajaxAuthor');
    Route::get('/ajaxComment/{slug}', [Front\BlogController::class, 'ajaxComment'])->name('ajaxComment');
    Route::get('/tag/{slug}', [Front\BlogController::class, 'tag'])->name('tag');
    Route::get('/category/{slug}', [Front\BlogController::class, 'category'])->name('category');
    Route::get('/all-posts', [Front\BlogController::class, 'allPosts'])->name('allPosts');
    Route::get('/search', [Front\BlogController::class, 'search'])->name('search');
    Route::get('/getCommentForm/{id}', [Front\BlogController::class, 'getCommentForm'])->name('getCommentForm');
    Route::get('/author/@{username}', [Front\BlogController::class, 'author'])->name('author');
    Route::get('/favoriteComment/add', [Front\BlogController::class, 'favoriteComment'])->name('favoriteComment');
    Route::post('/postComment/{id}', [Front\BlogController::class, 'postComment'])->name('postComment')->middleware(ProtectAgainstSpam::class);
 
    Route::middleware('module_publish:advanced_blog')->group(function () {
        Route::get('/packages', [Front\BlogController::class, 'package'])->name('package');
        Route::get('/packages/{slug}', [Front\BlogController::class, 'packageDetail'])->name('package.detail');
        Route::get('/packages/{id}/addtocart', [Front\BlogController::class, 'addtocart'])->name('package.addtocart');
    });
    Route::get(config('custom.route.blogDetail').'/{slug}', [Front\BlogController::class, 'detail'])->name('detail');
});

Route::get('/{url?}', [Front\PageController::class, 'index'])->where('url', '([A-Za-z0-9\-\/]+)')->name('home');

Route::middleware(['preventBackHistory'])->group(function () {
    Route::get('/{url?}', [\App\Http\Controllers\Front\PageController::class, 'index'])->where('url', '([A-Za-z0-9\-\/]+)')->name('home');
    Route::post('form/contact', [\App\Http\Controllers\Front\ContactController::class, 'index']);
});

Route::name('test.')->prefix('test')->group(function () {
    Route::get('/', [\App\Http\Controllers\TestController::class, 'index'])->name('sections');
})->middleware('admin');

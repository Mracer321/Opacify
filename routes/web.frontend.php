<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicePageController;
use App\Http\Controllers\TechnologyPageController;
use Illuminate\Support\Facades\Route;

Route::post('/enquiries', [EnquiryController::class, 'store'])
    ->middleware('throttle:enquiries')
    ->name('enquiries.store');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->middleware('guest')
    ->name('admin.login.store');

Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::redirect('/admin', '/admin/enquiries')->name('admin');
    Route::get('/admin/enquiries', [AdminEnquiryController::class, 'index'])->name('admin.enquiries.index');
    Route::get('/admin/enquiries/{enquiry}', [AdminEnquiryController::class, 'show'])->name('admin.enquiries.show');

    Route::resource('admin/projects', AdminProjectController::class)
        ->except(['show'])
        ->names('admin.projects');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/services', [ServicePageController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServicePageController::class, 'show'])->name('services.show');

Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

Route::view('/privacy-policy', 'pages.legal.privacy-policy')->name('privacy-policy');
Route::view('/terms', 'pages.legal.terms')->name('terms');
Route::view('/blog', 'pages.blog.index')->name('blog.index');
Route::view('/blog/{slug}', 'pages.blog.show')->name('blog.show');
Route::get('/case-studies', [CaseStudyController::class, 'index'])->name('case-studies.index');
Route::get('/case-studies/{slug}', [CaseStudyController::class, 'show'])->name('case-studies.show');
Route::view('/lp/hire-developers', 'pages.landing.ads')->name('landing.ads');

Route::view('/hire-laravel-developers', 'pages.hire-laravel-developers');
Route::view('/hire-react-developers', 'pages.hire-react-developers');
Route::view('/hire-nodejs-developers', 'pages.hire-nodejs-developers');
Route::view('/hire-flutter-developers', 'pages.hire-flutter-developers');

// Canonical hire-intent slugs are served by the dedicated /hire-*-developers pages.
// Permanently redirect the technology equivalents (previously linked via the broken
// fallback route) to avoid duplicate content and cannibalization.
Route::redirect('/technologies/laravel', '/hire-laravel-developers', 301);
Route::redirect('/technologies/react', '/hire-react-developers', 301);
Route::redirect('/technologies/nodejs', '/hire-nodejs-developers', 301);
Route::redirect('/technologies/flutter', '/hire-flutter-developers', 301);

Route::get('/technologies/{slug}', [TechnologyPageController::class, 'show'])->name('technologies.show');

<?php

use App\Http\Controllers\ServicePageController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');

Route::get('/services', [ServicePageController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServicePageController::class, 'show'])->name('services.show');

Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

Route::view('/privacy-policy', 'pages.legal.privacy-policy')->name('privacy-policy');
Route::view('/terms', 'pages.legal.terms')->name('terms');
Route::view('/blog', 'pages.blog.index')->name('blog.index');
Route::view('/blog/{slug}', 'pages.blog.show')->name('blog.show');
Route::view('/case-studies', 'pages.case-studies.index')->name('case-studies.index');
Route::view('/case-studies/{slug}', 'pages.case-studies.show')->name('case-studies.show');
Route::view('/lp/hire-developers', 'pages.landing.ads')->name('landing.ads');

Route::view('/hire-laravel-developers', 'pages.hire-laravel-developers');
Route::view('/hire-react-developers', 'pages.hire-react-developers');
Route::view('/hire-nodejs-developers', 'pages.hire-nodejs-developers');
Route::view('/hire-flutter-developers', 'pages.hire-flutter-developers');

Route::view('/technologies/{slug}', 'pages.technology')->name('technologies.show');

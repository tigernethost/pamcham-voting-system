<?php

use App\Http\Middleware\SetBackpackLayout;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::get('dashboard', 'DashboardController@index')->middleware(SetBackpackLayout::class); // set custom inertia layout for admin
    Route::crud('candidate', 'CandidateCrudController');
    Route::crud('voter', 'VoterCrudController');
    Route::get('voter/activate/{id}', 'VoterCrudController@activateVoter')->name('admin.activate');
    Route::crud('category', 'CategoryCrudController');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */

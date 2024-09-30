<?php

use App\Http\Controllers\Admin\VoterCrudController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\ProfileController;
use App\Models\Voter;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [VoterController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Voters

    Route::prefix('voter')->group(function() {
        Route::post('request-activation', [VoterCrudController::class, 'requestAccountActivation'])->name('voter.request_activation');
    });
});

Route::get('pamcham/{uuid}/voting-ballot', [VoterController::class, 'votingBallot'])->name('pamcham.voting-ballot');
Route::post('pamcham/{uuid}/voting-ballot/submit', [VoterController::class, 'submitVote'])->name('pamcham.voting-ballot.submit');
Route::get('/vote-success/{uuid}', function ($uuid) {

    $voter = Voter::where('uuid', $uuid)->first();

    return Inertia::render('VoteSuccess', compact('voter'));
});

// Route::get('/qrcode', function () {
//     return QrCode::size(200)->generate('tigernet-hosting-and-it-services');
// });

require __DIR__.'/auth.php';

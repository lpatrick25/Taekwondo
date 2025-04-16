<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SigninController;
use App\Models\Brgy;
use App\Models\Municipality;
use Illuminate\Http\Request;
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
    return view('signin');
})->name('login');

Route::post('login', [SigninController::class, 'signin'])->name('signin');
Route::get('isUsingDefaultPassword', [SigninController::class, 'isUsingDefaultPassword'])->name('isUsingDefaultPassword');
Route::post('/change-password', [SigninController::class, 'changePassword'])->name('changePassword');
Route::get('/userDashboard', [SigninController::class, 'userDashboard'])->middleware('auth')->name('userDashboard');
Route::get('logout', function (Request $request) {
    Auth::logout(); // Log the user out

    // Invalidate the session (optional if you're using sessions)
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/'); // Redirect to the login page
})->name('signout');
Route::get('/profile', [SigninController::class, 'profile'])->middleware('auth')->name('profile');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('adminDashboard');

    // Committee
    Route::get('committee', [AdminController::class, 'committee'])->name('committee');
    Route::get('addCommittee', [AdminController::class, 'addCommittee'])->name('addCommittee');

    // Chapter
    Route::get('chapter', [AdminController::class, 'chapter'])->name('chapter');
    Route::get('addChapter', [AdminController::class, 'addChapter'])->name('addChapter');
});

Route::prefix('coach')->middleware('auth')->group(function () {
    Route::get('dashboard', [CoachController::class, 'dashboard'])->name('coachDashboard');

    // Player
    Route::get('player', [CoachController::class, 'player'])->name('player');
    Route::get('addPlayer', [CoachController::class, 'addPlayer'])->name('addPlayer');

    Route::get('chapter', [CoachController::class, 'chapter'])->name('coachChapter');

    Route::get('/coachProfile', [CoachController::class, 'coachProfile'])->name('coachProfile');
});

Route::prefix('player')->middleware('auth')->group(function () {
    Route::get('dashboard', [NavigationController::class, 'dashboard'])->name('playerDashboard');

    Route::get('chapter', [NavigationController::class, 'chapter'])->name('playerChapter');

    Route::get('/playerProfile', [NavigationController::class, 'playerProfile'])->name('playerProfile');
});

Route::get('/get-municipalities/{provinceCode}', function ($provinceCode) {
    $municipalities = Municipality::where('province_code', $provinceCode)->get();
    return response()->json($municipalities);
})->middleware('auth');

Route::get('/get-brgys/{municipalityCode}', function ($municipalityCode) {
    $brgys = Brgy::where('municipality_code', $municipalityCode)->get();
    return response()->json($brgys);
})->middleware('auth');

Route::resource('committees', CommitteeController::class)->middleware('auth');
Route::resource('chapters', ChapterController::class)->middleware('auth');
Route::resource('players', PlayerController::class)->middleware('auth');

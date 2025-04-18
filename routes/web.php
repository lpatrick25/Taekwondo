<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\KyorugiTournamentController;
use App\Http\Controllers\KyorugiTournamentPlayerController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SigninController;
use App\Http\Controllers\TMController;
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
    Route::get('viewPlayer/{playerID}', [CoachController::class, 'viewPlayer'])->name('coachViewPlayer');

    Route::get('chapter', [CoachController::class, 'chapter'])->name('coachChapter');

    // Kyorugi
    Route::get('kyorugi', [CoachController::class, 'kyorugi'])->name('coachKyorugi');
    Route::get('kyorugiPlayer/{tournamentID}', [CoachController::class, 'kyorugiPlayer'])->name('coachKyorugiPlayer');

    Route::get('/coachProfile', [CoachController::class, 'coachProfile'])->name('coachProfile');
});

Route::prefix('player')->middleware('auth')->group(function () {
    Route::get('dashboard', [NavigationController::class, 'dashboard'])->name('playerDashboard');

    Route::get('chapter', [NavigationController::class, 'chapter'])->name('playerChapter');
    Route::get('viewPlayer/{playerID}', [NavigationController::class, 'viewPlayer'])->name('playerViewPlayer');

    Route::get('/playerProfile', [NavigationController::class, 'playerProfile'])->name('playerProfile');
});

Route::prefix('tm')->middleware('auth')->group(function () {
    Route::get('dashboard', [TMController::class, 'dashboard'])->name('tmDashboard');

    // Chapter
    Route::get('chapter', [TMController::class, 'chapter'])->name('tmChapter');
    Route::get('viewChapter/{chapterID}', [TMController::class, 'vieWChapter'])->name('tmViewChapter');

    // Player
    Route::get('player', [TMController::class, 'player'])->name('tmPlayer');
    Route::get('viewPlayer/{playerID}', [TMController::class, 'viewPlayer'])->name('tmViewPlayer');

    // Event Category
    Route::get('category', [TMController::class, 'category'])->name('tmCategory');

    // Kyorugi
    Route::get('kyorugi', [TMController::class, 'kyorugi'])->name('tmKyorugi');
    Route::get('addKyorugi', [TMController::class, 'addKyorugi'])->name('addKyorugi');
    Route::get('kyorugiPlayer', [TMController::class, 'kyorugiPlayer'])->name('tmKyorugiPlayer');

    Route::get('/tmProfile', [TMController::class, 'tmProfile'])->name('tmProfile');
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
Route::resource('eventCategories', EventCategoryController::class)->middleware('auth');
Route::resource('kyorugiTournaments', KyorugiTournamentController::class)->middleware('auth');
Route::resource('kyorugiTournamentPlayers', KyorugiTournamentPlayerController::class)->middleware('auth');

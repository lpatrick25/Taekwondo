<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\EventCategory;
use App\Models\KyorugiTournament;
use App\Models\KyorugiTournamentPlayer;
use App\Models\Player;
use App\Models\Province;
use Illuminate\Http\Request;

class TMController extends Controller
{
    public function dashboard()
    {
        return view("tm.dashboard");
    }

    public function chapter()
    {
        $chapters = Chapter::all();
        return view("tm.chapter", compact("chapters"));
    }

    public function viewChapter(int $chapterID)
    {
        $chapter = Chapter::findOrFail($chapterID);
        return view("tm.chapter_view", compact("chapter"));
    }

    public function player()
    {
        $players = Player::with(['user', 'chapter'])->get();

        return view('tm.player', compact('players'));
    }

    public function viewPlayer($playerID)
    {
        $player = Player::with('user')->findOrFail($playerID);
        return view('tm.player_view', compact('player'));
    }

    public function category()
    {
        $eventCategories = EventCategory::all();
        return view('tm.category', compact('eventCategories'));
    }

    public function kyorugi()
    {
        $kyorugis = KyorugiTournament::all();
        return view('tm.kyorugi', compact('kyorugis'));
    }

    public function addKyorugi()
    {
        $eventCategories = EventCategory::all();
        $provinces = Province::where('region_code', 8)->get();

        return view('tm.add_kyorugi', compact('provinces', 'eventCategories'));
    }

    public function kyorugiPlayer()
    {
        $kyorugis = KyorugiTournamentPlayer::all();
        return view('tm.kyorugi_player', compact('kyorugis'));
    }

    public function tmProfile()
    {
        $committee = auth()->user()->committee;

        if (!$committee) {
            abort(404, 'Committee not found.');
        }

        return view('tm.profile', compact('committee'));
    }
}

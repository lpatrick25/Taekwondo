<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function dashboard()
    {
        return view('player.dashboard');
    }

    public function chapter()
    {
        $player = auth()->user()->player;

        if (!$player) {
            abort(404, 'Player not found.');
        }

        $chapter = Chapter::where('coach_id', $player->coach_id)->first();

        return view('player.chapter', compact('chapter'));
    }

    public function playerProfile()
    {
        $player = auth()->user()->player;

        if (!$player) {
            abort(404, 'Player not found.');
        }

        return view('player.profile', compact('player'));
    }
}

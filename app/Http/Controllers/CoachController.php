<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Player;
use App\Models\Province;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function dashboard()
    {
        return view('coach.dashboard');
    }

    public function player()
    {
        // Fetch only the players that belong to the currently logged-in coach
        $players = auth()->user()->players;  // Using the players relationship defined in the User model

        return view('coach.player', compact('players'));
    }

    public function addPlayer()
    {
        // Fetch provinces for the coach's region (as in your code, assuming region code 8)
        $provinces = Province::where('region_code', 8)->get();

        return view('coach.add_player', compact('provinces'));
    }

    public function chapter()
    {
        $chapter = Chapter::where('coach_id',auth()->user()->id)->first();
        return view('coach.chapter', compact('chapter'));
    }

    public function coachProfile()
    {
        $committee = auth()->user()->committee;

        if (!$committee) {
            abort(404, 'Player not found.');
        }

        return view('coach.profile', compact('committee'));
    }
}

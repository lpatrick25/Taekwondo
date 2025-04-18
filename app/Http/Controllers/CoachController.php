<?php

namespace App\Http\Controllers;

use App\Enums\TournamentStatus;
use App\Models\Chapter;
use App\Models\KyorugiTournament;
use App\Models\KyorugiTournamentPlayer;
use App\Models\Player;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoachController extends Controller
{
    public function dashboard()
    {
        return view('coach.dashboard');
    }

    public function player()
    {
        $players = auth()->user()->chapter->players;

        return view('coach.player', compact('players'));
    }

    public function addPlayer()
    {
        // Fetch provinces for the coach's region (as in your code, assuming region code 8)
        $provinces = Province::where('region_code', 8)->get();

        return view('coach.add_player', compact('provinces'));
    }

    public function viewPlayer($playerID)
    {
        $player = Player::with('user')->findOrFail($playerID);
        return view('coach.player_view', compact('player'));
    }

    public function chapter()
    {
        $chapter = Chapter::where('coach_id', auth()->user()->id)->first();
        return view('coach.chapter', compact('chapter'));
    }

    public function coachProfile()
    {
        $committee = auth()->user()->committee;

        if (!$committee) {
            abort(404, 'Committee not found.');
        }

        return view('coach.profile', compact('committee'));
    }

    public function kyorugi()
    {
        $kyorugis = KyorugiTournament::where('status', '!=', TournamentStatus::DRAFT)->get();
        return view('coach.kyorugi', compact('kyorugis'));
    }

    public function kyorugiPlayer($tournament_id)
    {
        $coachId = auth()->id();

        // Get all player IDs under this coach
        $playerIds = Player::where('coach_id', $coachId)->pluck('user_id');

        // Get IDs of players already registered to this tournament
        $registeredPlayerIds = DB::table('kyorugi_tournament_player')
            ->where('tournament_id', $tournament_id)
            ->pluck('player_id')
            ->toArray();

        // Get players of this coach NOT in the registered list
        $unregisteredPlayers = Player::where('coach_id', $coachId)
            ->whereNotIn('user_id', $registeredPlayerIds)
            ->get();

        // Optionally still load the tournament for other data
        $tournament = KyorugiTournament::findOrFail($tournament_id);

        $registeredPlayers = KyorugiTournamentPlayer::with(['tournament', 'player'])
            ->whereIn('player_id', $playerIds)
            ->get();

        return view('coach.kyorugi_player', compact('tournament', 'unregisteredPlayers', 'registeredPlayers'));
    }
}

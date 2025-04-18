<?php

namespace App\Models;

use App\Enums\MatchStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KyorugiTournamentMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'match_number',
        'player1_id',
        'player2_id',
        'match_status',
        'winner_id',
        'loser_id',
        'created_by',
    ];

    protected $casts = [
        'match_status' => MatchStatus::class,
    ];

    protected $with = [
        'player1',
        'player2',
    ];

    public function player1(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player1_id');
    }

    public function player2(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player2_id');
    }

    public function loser(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'loser_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tournament()
    {
        return $this->belongsTo(KyorugiTournament::class);
    }

    public function redPlayer()
    {
        return $this->belongsTo(User::class, 'player_red_id');
    }

    public function bluePlayer()
    {
        return $this->belongsTo(User::class, 'player_blue_id');
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }
}

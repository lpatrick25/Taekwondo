<?php

namespace App\Models;

use App\Enums\BeltLevel;
use App\Enums\Division;
use App\Enums\PlayerStatus;
use Illuminate\Database\Eloquent\Model;

class KyorugiTournamentPlayer extends Model
{
    protected $table = 'kyorugi_tournament_player';

    protected $fillable = [
        'tournament_id',
        'player_id',
        'division',
        'weight_class',
        'belt_level',
        'gender',
        'status',
        'registered_by',
    ];

    protected $casts = [
        'division' => Division::class,
        'belt_level' => BeltLevel::class,
        'status' => PlayerStatus::class,
    ];
}

<?php

namespace App\Models;

use App\Enums\BeltLevel;
use App\Enums\Division;
use App\Enums\PlayerStatus;
use App\Enums\WeightCategory;
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
        'weight_class' => WeightCategory::class,
    ];

    public function tournament()
    {
        return $this->belongsTo(KyorugiTournament::class);
    }

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }
}

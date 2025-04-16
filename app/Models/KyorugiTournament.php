<?php

namespace App\Models;

use App\Enums\TournamentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class KyorugiTournament extends Model
{
    protected $fillable = [
        'event_category_id',
        'name',
        'start_date',
        'end_date',
        'registration_start',
        'registration_end',
        'venue_name',
        'province_code',
        'municipality_code',
        'brgy_code',
        'created_by',
        'status',
        'remarks'
    ];

    protected $casts = [
        'status' => TournamentStatus::class,
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_start' => 'date',
        'registration_end' => 'date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'kyorugi_tournament_player', 'tournament_id', 'player_id')
            ->withPivot(['weight_class', 'belt_level', 'status', 'registered_by'])
            ->withTimestamps();
    }
}

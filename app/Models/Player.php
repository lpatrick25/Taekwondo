<?php

namespace App\Models;

use App\Enums\BeltLevel;
use App\Enums\CivilStatus;
use App\Enums\Religion;
use App\Traits\HasAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasAddress;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'coach_id',
        'chapter_id',
        'member_id',
        'pta_id',
        'ncc_id',
        'birth_date',
        'gender',
        'civil_status',
        'belt_level',
        'religion',
        'province_code',
        'municipality_code',
        'brgy_code',
    ];

    protected $casts = [
        'civil_status' => CivilStatus::class,
        'belt_level' => BeltLevel::class,
        'religion' => Religion::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'province_code');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_code', 'municipality_code');
    }

    public function brgy()
    {
        return $this->belongsTo(Brgy::class, 'brgy_code', 'brgy_code');
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function tournaments()
    {
        return $this->belongsToMany(KyorugiTournament::class, 'kyorugi_tournament_player', 'player_id', 'tournament_id')
            ->withPivot(['weight_class', 'belt_level', 'status', 'registered_by'])
            ->withTimestamps();
    }
}

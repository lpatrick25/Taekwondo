<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasFullName;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFullName;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'extension_name',
        'email',
        'contact_number',
        'user_type',
        'password',
    ];

    protected $casts = [
        'user_type' => UserType::class,
    ];

    public function player(): HasOne
    {
        return $this->hasOne(Player::class);
    }

    public function committee(): HasOne
    {
        return $this->hasOne(Committee::class);
    }

    // For coach owning a chapter
    public function chapter(): HasOne
    {
        return $this->hasOne(Chapter::class, 'coach_id');
    }

    // For coach having multiple players
    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'coach_id');
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(200)
            ->height(200)
            ->optimize()
            ->performOnCollections('avatar');

        $this->addMediaConversion('web_thumbnail')
            ->width(360)
            ->height(360)
            ->optimize()
            ->performOnCollections('avatar');

        $this->addMediaConversion('responsive')
            ->height(720)
            ->width(720)
            ->withResponsiveImages()
            ->optimize()
            ->performOnCollections('avatar');
    }
}

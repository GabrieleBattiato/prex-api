<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Other properties and methods...

    public function gif(): HasOne
    {
        return $this->hasOne(GifUser::class);
    }

    /**
     * Add a GIF to the user's favorites.
     *
     * @param string $gifId
     * @param string $alias
     * @return void
     */
    public function setFavoriteGif(string $gifId, string $alias): void
    {
        $this->gif()->updateOrInsert(
            ['user_id' => $this->id],
            ['gif_id' => $gifId, 'alias' => $alias]
        );
    }

    /**
     * Get user interactions
     */
    public function serviceLogs(): HasMany
    {
        return $this->hasMany(UserServiceInteraction::class);
    }
}

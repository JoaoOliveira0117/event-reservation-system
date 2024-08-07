<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticable
{
    use HasApiTokens, HasFactory, HasUuids;

    protected $fillable = [
        "username",
        "email",
        "password"
    ];

    protected $hidden = [
        "password"
    ];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => bcrypt($value)
        );
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, Ticket::class);
    }
}

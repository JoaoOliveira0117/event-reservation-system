<?php

namespace App\Models;

use App\Builders\EventBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "title",
        "description",
        "deadline",
        "date",
        "location",
        "price",
        "attendee_limit",
        "status",
        "user_id"
    ];

    protected $hidden = ['user_id', 'pivot'];

    protected $casts = [
        "price" => "float",
        "deadline" => "datetime",
        "date" => "datetime"
    ];

    public function newEloquentBuilder($query): EventBuilder
    {
        return new EventBuilder($query);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Ticket::class);
    }
}

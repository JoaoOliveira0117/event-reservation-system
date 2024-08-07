<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $casts = [
        "price" => "float",
        "deadline" => "datetime",
        "date" => "datetime"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

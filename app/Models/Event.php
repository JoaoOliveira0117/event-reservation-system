<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        "status"
    ];

    protected $casts = [
        "price" => "float",
        "deadline" => "datetime",
        "date" => "datetime"
    ];
}

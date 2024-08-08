<?php

namespace App\Models;

use App\Builders\TicketBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $primaryKey = ['user_id', 'event_id'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        "user_id",
        "event_id",
        "status"
    ];

    public function newEloquentBuilder($query): TicketBuilder
    {
        return new TicketBuilder($query);
    }

    // Implemented because of issues when executing update;
    protected function setKeysForSaveQuery($query)
    {
        $query->where('user_id', $this->getAttribute('user_id'))
              ->where('event_id', $this->getAttribute('event_id'));
        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}

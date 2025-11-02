<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    /** @use HasFactory<\Database\Factories\BidFactory> */
    use HasFactory;

    public function project() :BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    public function client() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

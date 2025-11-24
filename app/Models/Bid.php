<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    /** @use HasFactory<\Database\Factories\BidFactory> */
    use HasFactory;


    protected $fillable=['bid','project_id','freelancer_id'];

    public function project() :BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    public function client() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

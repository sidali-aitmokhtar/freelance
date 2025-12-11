<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    /** @use HasFactory<\Database\Factories\BidFactory> */
    use HasFactory;


    protected $fillable=['bid','project_id','freelancer_id','months','days','status','milestone_json'];


    protected $casts = [
        'milestone_json' => 'json',
    ];

    public function project() :BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    public function freelancer() :BelongsTo
    {
        return $this->belongsTo(User::class,'freelancer_id');
    }
}

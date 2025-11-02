<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;
    protected $fillable=['client_id'];
    public function publisher() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function bids() :HasMany
    {
        return $this->hasMany(Bid::class,'project_id');
    }
    public function contract() :HasOne
    {
        return $this->hasOne(Contract::class);
    }
}

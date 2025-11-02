<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contract extends Model
{
    /** @use HasFactory<\Database\Factories\ContractFactory> */
    use HasFactory;

    protected $fillable=['price'];

    public function freelancer(): BelongsTo
    {
        return $this->belongsTo(User::class,'freelancer_id');
    }
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function escrow(): HasOne
    {
        return $this->hasOne(EscrowTransaction::class);
    }
}

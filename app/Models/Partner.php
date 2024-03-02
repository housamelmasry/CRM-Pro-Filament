<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partner extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class , 'user_id' , 'id')
            ->withDefault();
    }

    public function partner():HasMany
    {
        return $this->hasMany(Partner::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable =
    [

        'name',
        'user_id',
        'type_of_Business',
        'size',
        'country_id',
        'state_id',
        'city_id',
        'phone',
        'email',
        'website',
        'slogan',
        'about_us',
        'mission',
        'vision',

    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    // public function client(): HasMany
    // {
    //     return $this->hasMany(Client::class);
    // }

    public function project(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    // public function meeting(): HasMany
    // {
    //     return $this->hasMany(Meeting::class);
    // }

    // public function proposal(): HasMany
    // {
    //     return $this->hasMany(Proposal::class);
    // }

    // public function order(): HasMany
    // {
    //     return $this->hasMany(Order::class);
    // }

    // public function category(): HasMany
    // {
    //     return $this->hasMany(Category::class);
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

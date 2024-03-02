<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class Project extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'title',
        'description',
        'start_Date',
        'end_Date',
        'priority',
        'status',
        'location',
        'type',
        'department_id',
        'user_id',
        'client_id',
        'company_id',
    ];

    // public function client(): BelongsToMany
    // {
    //     return $this->belongsToMany(Client::class);
    // }
    // public function getStatuses(): Collection
    // {
    //     return StatusEnum::statuses();
    // }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    // public function proposal():BelongsTo
    // {
    //     return $this->belongsTo(Proposal::class);
    // }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }


    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }


    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }


    // public function category(): HasMany
    // {
    //     return $this->hasMany(Category::class);
    // }


    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }

}

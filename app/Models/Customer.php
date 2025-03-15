<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
    ];


    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function transaction(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
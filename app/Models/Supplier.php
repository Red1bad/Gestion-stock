<?php

namespace App\Models;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
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

    public function productSup(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    public function transaction(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

}
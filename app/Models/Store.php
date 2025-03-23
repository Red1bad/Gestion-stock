<?php

namespace App\Models;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Store extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'address',
        'phone',
    ];


    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class);
    }


    public function productStore(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, Stock::class);
    }

}
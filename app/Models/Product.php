<?php

namespace App\Models;

use App\Models\Stock;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'description',
        'price',
        'picture',
        'category_id',
        'supplier_id',
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }


    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }


    public function orderProduct(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'product_orders')
                    ->withPivot(['quantity', 'price'])
                    ->withTimestamps();
    }
}
<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $appends = ['priceAfterDiscount'];
    protected $guarded = [];
    // protected $with = ['category'];

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryProduct::class, 'category_product_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['q'] ?? false, function ($query, $q) {
            return $query->where('name', 'like', '%' . $q . '%');
            // ->orWhere('description', 'like', '%' . $q . '%');
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            return $query->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });

        // $query->when($filters['author'] ?? false, fn ($query, $author) => $query->whereHas('author', fn ($query) => $query->where('username', $author)));
    }

    public function getPriceAfterDiscountAttribute()
    {
        return \round($this->price - ($this->price * ($this->discount / 100)));
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}

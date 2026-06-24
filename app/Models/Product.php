<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'shop_id',
        'category_id',
        'title',
        'slug',
        'description',
        'featured_image',
        'materials',
        'lead_time',
        'price',
        'contact_price',
        'is_featured',
        'status',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'materials' => 'array',
            'price' => 'decimal:2',
            'contact_price' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}

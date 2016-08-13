<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'price',
        'category_id',
        'image',
        'published_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|User
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

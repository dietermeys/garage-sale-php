<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps = false;
    protected $table = 'product_photos';
    protected $fillable = [
        'filename',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

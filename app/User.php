<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Cmgmyr\Messenger\Traits\Messagable;

class User extends Authenticatable
{
    use Messagable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'street',
        'nr',
        'bus',
        'zip',
        'city',
        'lat',
        'lng'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productsForSale()
    {
        return $this->hasMany(Product::class, "user_id");
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    /**
     * Favorite/Unfavorite a product
     * Returns true when favored, false when unfavored
     *
     * @param Product $product
     * @return bool
     */
    public function toggleFavorited(Product $product) {
        $favorite = $this->favorites()->firstOrCreate([
            'product_id' => $product->id,
            'user_id' => $this->id,
        ]);

        if (!$favorite->wasRecentlyCreated)
            $favorite->delete();

        return $favorite->wasRecentlyCreated;
    }
}

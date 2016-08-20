<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'price',
        'category_id',
        'published_at'
    ];

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getDistanceAttribute($value)
    {
        $user = \Auth::user();
        $distance = DistanceCalculator::calculate($user->lat, $user->lng, $this->seller->lat, $this->seller->lng);
        $this->attributes['distance'] = $distance;
        return $distance;
    }

    /**
     * Check if this product is favorited
     *
     * @param  string  $value
     * @return string
     */
    public function getIsFavoritedAttribute($value)
    {
        $user = auth()->user();
        return $this->hasFavorited($user);
    }

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

    public function photos()
    {
        return $this->hasMany(Image::class, 'product_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function hasFavorited(User $user)
    {
        return $this->favorites()
            ->whereUserId($user->id)
            ->get()
            ->count() > 0;
    }

    /**
     * Scope a query to only include nearby products
     * http://stackoverflow.com/a/1006769
     *
     * @param $query
     * @param $user
     * @param int $maxDistance
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeCloseBy($query, $user, $maxDistance = null)
    {
        /* @var \Illuminate\Database\Query\Builder $query */
        $query->join("users AS sellers", "sellers.id", "=", "products.user_id");
        $query->selectRaw('products.*');
        $query->selectRaw("( 6371 * acos( cos( radians($user->lat) )
                * cos( radians( sellers.lat ) )
                * cos( radians( sellers.lng ) - radians($user->lng) )
                + sin( radians($user->lat) )
                * sin( radians( sellers.lat ) ) ) ) AS distance ");

        if (!is_null($maxDistance)) {
            $query->having("distance", "<", $maxDistance);
        }

        $query->orderBy('distance');
        return $query;
    }

    /**
     * Create a query builder that includes the product distance
     *
     * @return Builder
     */
    public static function withDistance($maxDistance = null)
    {
        $query = static::query();
        return (new static)->scopeCloseBy($query, auth()->user(), $maxDistance);
    }
}

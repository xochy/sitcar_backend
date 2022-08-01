<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory, Sluggable, SluggableScopeHelpers;

    /**
     * Name of columns to fill resource and save
     *
     * @var array
     */
    protected $fillable = ['name', 'price', 'trademark', 'year', 'sold'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slugForSave'
            ]
        ];
    }

    /**
     * Return the slug for this model.
     *
     * @return string
     */
    public function getSlugForSaveAttribute(): string
    {
        return Str::uuid();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /* -------------------------------------------------------------------------- */
    /*                                Relationships                               */
    /* -------------------------------------------------------------------------- */

    /**
     * Get all of the car's images.
     *
     * @return MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /* -------------------------------------------------------------------------- */
    /*                                   Scopes                                   */
    /* -------------------------------------------------------------------------- */

    /**
     * Apply the scope related with name.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     * @param string
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeName(Builder $query, $value)
    {
        $query->where('name', 'LIKE', "%{$value}%");
    }

    /**
     * Apply the scope related with price.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     * @param string
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrice(Builder $query, $value)
    {
        $query->where('price', 'LIKE', $value);
    }

    /**
     * Apply the scope related with trademark.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     * @param string
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTrademark(Builder $query, $value)
    {
        $query->where('trademark', 'LIKE', "%{$value}%");
    }

    /**
     * Apply the scope related with year.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     * @param string
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeYear(Builder $query, $value)
    {
        $query->where('year', 'LIKE', "%{$value}%");
    }

    /**
     * Apply the scope related with sold.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     * @param string
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSold(Builder $query, $value)
    {
        $query->where('sold', 'LIKE', $value);
    }

    /**
     * Apply the scope related with search function.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param array
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, $values)
    {
        foreach (Str::of($values)->explode(' ') as $value) {

            $query->orWhere('name', 'LIKE', "%{$value}%")
            ->orWhere('trademark', 'LIKE', "%{$value}%");
        }
    }
}

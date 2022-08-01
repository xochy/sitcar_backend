<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['imageable_id', 'imageable_type', 'path', 'kind'];

    /**
     * Image any application services.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            Storage::delete($image->path);
        });
    }

    /* -------------------------------------------------------------------------- */
    /*                                Relationships                               */
    /* -------------------------------------------------------------------------- */

    /**
     * Get the parent imageable model (posts, questions).
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}

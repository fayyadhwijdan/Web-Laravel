<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'image', 'linkcapcut', 'duration'
    ];

    /**
     * image
     *
     * @return Attribute
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => url('/storage/playlists/' . $value),
        );
    }

    /**
     * content
     *
     * @return void
     */
    public function contents()
    {
        return $this->hasMany(Content::class);
    }
    /**
     * post
     *
     * @return void
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

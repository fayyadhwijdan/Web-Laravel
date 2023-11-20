<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject; // <-- import JWTSubject
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements JWTSubject //
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * invoice
     *
     * @return void
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * carts
     *
     * @return void
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
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
     * playlist
     *
     * @return void
     */
    public function playlists()
    {
        return $this->hasMany(Playlist::class);
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

    /**
     * putar
     *
     * @return void
     */
    public function putars()
    {
        return $this->hasMany(Putar::class);
    }

    /**
     * getJWTIdentifier
     *
     * @return void
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
        
    /**
     * getJWTCustomClaims
     *
     * @return void
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
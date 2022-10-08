<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin',
        'company_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'admin' => 'boolean',
        'config' => 'array'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['active'];

    /**
    * The relationships that should always be loaded.
    *
    * @var array
    */
   protected $with = ['company'];

    public function dates()
    {
        return $this->hasMany(Date::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**     
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function active(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => !!$this->remember_token
        );
    }
}

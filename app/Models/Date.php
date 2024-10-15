<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Date extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['has_free_seats', 'already_reserved','already_waiting', 'old', 'date_for_humans'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
        'places' => 'collection',
        'waiting' => 'collection',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }    

    /**    
     * 
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function dateForHumans(): Attribute
    {
        return new Attribute(
            get: fn () => $this->date->translatedFormat('D d F Y à H\hi')
        );
    }

    /**    
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function hasFreeSeats(): Attribute
    {
        return new Attribute(
            get: fn () => $this->places->filter(fn ($place) => $place === null)->count()
        );
    }

    /**     
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function alreadyReserved(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => $this->places->contains(Auth::id())
        );
    }

    /**     
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function alreadyWaiting(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => $this->waiting->contains(Auth::id())
        );
    }

    /**     
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function old(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => $this->date->endOfDay() < now()
        );
    }    
}

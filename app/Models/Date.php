<?php

namespace App\Models;

use DateTimeInterface;
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
    protected $appends = ['has_free_seats', 'already_reserved', 'old'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'places' => 'array'       
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**    
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function date(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Carbon::create($value)->translatedFormat('D d F Y à H\hi')
        );
    }

    /**    
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function hasFreeSeats(): Attribute
    {
        return new Attribute(
            get: fn () => count(array_filter($this->places, fn ($place) => $place === null))
        );
    }

    /**     
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function alreadyReserved(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => collect($this->places)->contains('id', Auth::id())
        );
    }

    /**     
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function old(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => $this->date < now()
        );
    }
}

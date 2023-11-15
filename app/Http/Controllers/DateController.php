<?php

namespace App\Http\Controllers;

use App\Models\Date;
use App\Http\Requests\StoreDateRequest;
use App\Mail\UserFromWaitingToPresent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DateController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDateRequest  $request
     * 
     */
    public function store(StoreDateRequest $request): void
    {
        Date::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'places' => array_fill(0, $request->places, null),
            'waiting' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Date  $date
     * @return Date
     */
    public function switch(Date $date): Date
    {
        if (request()->key === null)
            $this->reserveOrCancelDate($date);
        else
            $this->reserveOrCancelDateSlot($date->places);
        $date->save();
        return $date;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Date  $date
     * @return Date
     */
    public function waiting(Date $date): Date
    {
        $waiting = $date->waiting;
        if ($waiting->firstWhere('id', Auth::id()))
            $waiting = $waiting->filter(fn ($user) => Auth::user()->isNot($user));
        else
            $waiting->push(Auth::user());
        $date->waiting = $waiting;
        $date->save();
        return $date;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Collection<User|null>  $places
     * 
     */
    private function reserveOrCancelDate(Date $date): void
    {
        $places = $date->places;
        $waiting = $date->waiting;
        if ($places->firstWhere('id', Auth::id())) {
            $waitingUser = $waiting->shift();
            $places->transform(fn ($user) => Auth::user()->is($user) ? $waitingUser : $user);
            if ($waitingUser) {
                Mail::to($waitingUser)->send(new UserFromWaitingToPresent($waitingUser, $date));
                $date->waiting = $waiting;
            }
        } else {
            $free = $places->search(fn ($user) => !$user);
            if ($free !== false) {
                $places[$free] = Auth::user();
            }
        }
        $date->places = $places;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Collection<User|null>  $places
     * 
     */
    private function reserveOrCancelDateSlot($places): void
    {
        if ($places[request()->key] && $places[request()->key]['id'] == Auth::id())
            $places[request()->key] = null;
        elseif ($places[request()->key] === null)
            $places[request()->key] = Auth::user();
    }

    /**
     * Update the specified resource in storage.
     *     
     * @param  Date $date
     * @return Date
     */
    public function update(Date $date): Date
    {
        $this->authorize($date);
        $date->places[request()->key] = null;
        $date->save();
        return $date;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Date $date
     * 
     */
    public function destroy(Date $date): void
    {
        $date->delete();
    }
}

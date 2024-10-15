<?php

namespace App\Http\Controllers;

use App\Actions\CheckWaitings;
use App\Models\Date;
use App\Http\Requests\StoreDateRequest;
use App\Mail\UserFromWaitingToPresent;
use App\Models\User;
use Carbon\Carbon;
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
        $dateDate = new Carbon($request->date);
        $dateUntil = $request->until ? new Carbon($request->until) : new Carbon($request->date);
        $repeat =  $dateDate->diffInWeeks($dateUntil);
        $places = collect($request->group ?? [])->pad($request->places, null)->take($request->places);

        for ($i = 0; $i <= $repeat; $i++) {
            Date::create([
                'user_id' => Auth::id(),
                'date' => $dateDate,
                'places' =>  $places,
                'waiting' => [],
            ]);
            $dateDate->addWeek();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Date  $date
     * 
     * @return Date
     */
    public function switch(Date $date): Date
    {
        if (request()->key === null)
            $this->reserveOrCancelDate($date);
        else
            $this->reserveOrCancelDateSlot($date);

        CheckWaitings::check($date);
        return $date;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Date  $date
     * @param  User  $user
     * 
     * @return Date
     */
    public function change(Date $date, User $user): Date
    {
        $places = $date->places;

        foreach ($places as $key => $place) {
            if (request()->key === $key)
                $places[$key] = $user->id;
            else if ($user->id === $place)
                $places[$key] = null;
        }
        $date->update(['places' => $places]);

        CheckWaitings::check($date);
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
    
        if ($waiting->contains(Auth::id()))
            $waiting = $waiting->filter(fn($userId) => Auth::id() !== $userId)->values();
        else
            $waiting->push(Auth::id());

        $date->update(['waiting' => $waiting]);

        CheckWaitings::check($date);
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
        $free = $places->search(null, true);

        if ($places->contains(Auth::id()))
            $places->transform(fn($userId) => Auth::id() === $userId ? null : $userId);
        else if ($free !== false)
            $places[$free] = Auth::id();

        $date->update(['places' => $places]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Collection<User|null>  $places
     * 
     */
    private function reserveOrCancelDateSlot(Date $date): void
    {
        $places = $date->places;

        if ($places[request()->key] === Auth::id())
            $places[request()->key] = null;
        elseif ($places[request()->key] === null)
            $places[request()->key] = Auth::id();

        $date->update(['places' => $places]);
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
        $places = $date->places;
        $places[request()->key] = null;

        $date->update(['places' => $places]);

        CheckWaitings::check($date);
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

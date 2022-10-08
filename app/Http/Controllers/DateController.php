<?php

namespace App\Http\Controllers;

use App\Models\Date;
use App\Http\Requests\StoreDateRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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
            'places' => array_fill(0, $request->places, null)
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
            $this->reserveOrCancelDate($date->places);
        else
            $this->reserveOrCancelDateSlot($date->places);
        $date->save();
        return $date;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Collection<User|null>  $places
     * 
     */
    private function reserveOrCancelDate($places): void
    {
        if ($places->firstWhere('id', Auth::id())) {
            $places->transform(fn ($user) => Auth::user()->is($user) ? null : $user);
        } else {
            $free = $places->search(fn ($user) => !$user);
            if ($free !== false) {
                $places[$free] = Auth::user();
            }
        }
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

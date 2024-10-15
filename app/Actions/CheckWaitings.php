<?php

namespace App\Actions;

use App\Models\Date;
use App\Mail\UserFromWaitingToPresent;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class CheckWaitings
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  Date  $date
     * 
     * @return Date
     */
    public static function check(Date $date): void
    {
        $places = $date->places;
        $waiting = $date->waiting;

        foreach ($places as $key => $place) {
            if ($place !== null)
                continue;

            $waitingUser = $waiting->shift();
            if ($waitingUser === null)
                continue;

            $places[$key] = $waitingUser;
            Mail::to(User::find($waitingUser))->send(new UserFromWaitingToPresent(User::find($waitingUser), $date));
            $date->waiting = $waiting;
        }

        $date->update(['places' => $places, 'waiting' => $waiting]);
    }
}

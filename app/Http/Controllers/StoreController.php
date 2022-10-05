<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Date;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        foreach (Date::all() as $date) {
            $places = json_decode($date->getRawOriginal('places'));

            $date->places = collect($places)->map(fn ($place) => User::find($place?->id));
            $date->save();
        }


        $dates = Date::with('user')->orderBy('date')->get();
        $users = User::with('company')->where('admin', false)->get();

        return ['dates' => $dates, 'users' => $users, 'auth' => Auth::user()->load('company')];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Date;
use App\Models\User;
use Illuminate\Http\Request;

class storeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $old = Date::selectRaw("*,true as old")->whereDate('date', '<', now()->toDateString())->orderBy('date', 'desc')->get();
        $new = Date::selectRaw("*,false as old")->whereDate('date', '>=', now()->toDateString())->orderBy('date')->get();
        $users = User::where('active', true)->where('admin', false)->get();
        return ['dates' => [...$new, ...$old], 'users' => $users];
    }
}

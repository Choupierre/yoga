<?php

namespace App\Http\Controllers;

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
        $dates = Date::with('user')->orderBy('date')->get();
        $users = User::where('admin', false)->get();

        return ['dates' => $dates, 'users' => $users, 'auth' => Auth::user()];
    }
}

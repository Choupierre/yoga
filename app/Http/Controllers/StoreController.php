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
        $dates = Date::whereHas('user', fn ($query) => $query->where('company_id', Auth::user()->company_id))->orderBy('date')->get();      
        $users = User::where('company_id', Auth::user()->company_id)->where('admin', false)->get();

        return ['dates' => $dates, 'users' => $users, 'auth' => Auth::user()->load('company')];
    }
}

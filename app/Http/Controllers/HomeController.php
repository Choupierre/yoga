<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
       /*  $user=Auth::user();  
        if ($user && !$user->email_verified_at){
            $user->email_verified_at=now();
            $user->save();       
        }   */
        return Inertia::render('Home');
    }
}

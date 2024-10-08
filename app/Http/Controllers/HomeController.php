<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *     
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {      
        return Inertia::render('App');
    }
}

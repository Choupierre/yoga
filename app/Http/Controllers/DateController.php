<?php

namespace App\Http\Controllers;

use App\Models\Date;
use App\Http\Requests\StoreDateRequest;
use App\Http\Requests\UpdateDateRequest;
use Illuminate\Support\Facades\Auth;

class DateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDateRequest $request)
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
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function switch(Date $date)
    {
        $places = collect($date->places);
        $in = !!$places->firstWhere('id', Auth::id());
        if ($in) {
            $places->transform(function ($user, $key) {
                return ($user && $user['id'] === Auth::id()) ? null : $user;
            });
        } else {
            $free = $places->search(function ($user, $key) {
                return $user === null;
            });
            if ($free !== false) {
                $places->splice($free, 1, [Auth::user()]);
            }
        }

        $date->places = $places;
        $date->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function switch2(Date $date)
    {
        $places = collect($date->places);

        if ($places[request()->key] && $places[request()->key]['id'] == Auth::id())
            $places[request()->key] = null;
        elseif ($places[request()->key] === null)
            $places[request()->key] = Auth::user();


        $date->places = $places;
        $date->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Date  $date
     * @return \Illuminate\Http\Response
     */
    public function show(Date $date)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Date  $date
     * @return \Illuminate\Http\Response
     */
    public function edit(Date $date)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDateRequest  $request
     * @param  \App\Models\Date  $date
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDateRequest $request, Date $date)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Date  $date
     * @return \Illuminate\Http\Response
     */
    public function destroy(Date $date)
    {
        $date->delete();
    }
}

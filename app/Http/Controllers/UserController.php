<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\NewUserWelcomeMail;
use App\Models\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return User::where('active',true)->where('admin',false)->get();
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
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'config' => ['mail' => true, 'mailNotified' => false, 'notify_all' => true],
            'orchestra_id' => 1,
            'password' => Hash::make('dsfgdsfgsfgfdsg'),
        ]);
        Mail::to($user)->send(new NewUserWelcomeMail($user));
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {   
       
        foreach (Date::whereDate('date','>',now()->toDateString())->get() as $date) {       
            $places = collect($date->places);
            $places->transform(function ($placedUser, $key) use ($user) {             
                return ($placedUser && $placedUser['id'] === $user->id) ? null : $placedUser;
            });
            $date->places = $places;
            $date->save();
        }             
        $user->active=false;
        $user->save();
        return User::where('active',true)->where('admin',false)->get();
    }
}

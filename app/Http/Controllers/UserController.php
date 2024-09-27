<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\NewInsaUserWelcomeMail;
use App\Mail\NewPiccoloUserWelcomeMail;
use App\Mail\NewYogaUserWelcomeMail;
use App\Mail\UserFromWaitingToPresent;
use App\Models\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {}

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
            'config' => ['group' => false, 'slots' => 5, 'display_teacher_name' => true, 'duration' => 60],
            'company_id' => Auth::user()->company_id,
            'password' => Hash::make('dsfgdsfgsfgfdsg'),
        ]);
        if (config('app.name') === "Yoga")
            Mail::to($user)->send(new NewYogaUserWelcomeMail($user));
        if (config('app.name') === "Insa")
            Mail::to($user)->send(new NewInsaUserWelcomeMail($user));
        if (config('app.name') === "Piccolo")
            Mail::to($user)->send(new NewPiccoloUserWelcomeMail($user));
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
    public function update(Request $request, User $user)
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

        foreach (Date::all() as $date) {
            $places = $date->places;
            $waiting = $date->waiting;

            if ($places->firstWhere('id', $user->id)) {
                $waitingUser = $waiting->shift();
                $places->transform(function ($placedUser, $key) use ($user) {
                    return ($placedUser && $placedUser['id'] === $user->id) ? null : $placedUser;
                });
                $date->places = $places;
                if ($waitingUser)
                    Mail::to($waitingUser)->send(new UserFromWaitingToPresent($waitingUser, $date));
            }

            $date->waiting =  $waiting->filter(fn($u) => $u->isNot($user));
            $date->save();
        }
        $user->delete();
    }
}

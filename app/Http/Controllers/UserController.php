<?php

namespace App\Http\Controllers;

use App\Actions\CheckWaitings;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
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
            'password' => Hash::make('azerty'),
        ]);
        if (config('app.name') === "Yoga" || config('app.name') === "Orezen")
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
     * Update the specified resource in storage.
     *
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
        $user->update(['active' => !$user->active]);
        if ($user->active)
            return;


        $user->company->update(['groups' => $user->company->groups->filter(fn($userId) => $userId !== $user->id)->values()]);

        foreach (Date::all() as $date) {
            if ($date->waiting->contains($user->id)){
                $date->update(['waiting' => $date->waiting->filter(fn($userId) => $userId !== $user->id)->values()]);
            }

        }
    }
}

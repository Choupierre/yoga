<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use App\Models\Date;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $companie = Company::create(['name' => 'Yoga', 'groups' => []]);

        $kissline = User::create([
            'company_id' => $companie->id,
            'password' => Hash::make('azerty'),
            'email' => 'kissline@orezenyoga.com',
            'name' => 'Kissline',
            'config' => ['group' => true, 'slots' => 10, 'display_teacher_name' => true, 'duration' => 60],
            'admin' => true,
        ]);

        $users = User::factory(10)->create();
        $waitingUsers = User::factory(2)->create();

        /*     for ($i = -5; $i < 10; $i++) {
            $randomWaitings = $waitingUsers->random(rand(0, 2));
            Date::create(['date' => now()->addWeeks($i)->hour(12)->minute(15), 'user_id' => $kissline->id, 'places' => $users, 'waiting' => $randomWaitings]);
        } */
    }
}

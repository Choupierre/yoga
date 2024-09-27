<?php

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Company::create(['name' => 'Piccolo']);
        Company::create(['name' => 'Insa']);

        User::create([
            'company_id' => 1,
            'password' => Hash::make('azerty'),
            'email' => 'harmonie1610@gmail.com',
            'name' => 'Harmonie Maltere',
            'config' => ['group' => false, 'slots' => 5, 'display_teacher_name' => true, 'duration' => 60],
            'admin' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('admin')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

      /*   User::create([
            'password' => Hash::make('azerty'),
            'email' => 'raphaelle.leclerc@hotmail.com',
            'name' => 'Raphaelle Leclerc',
            'admin' => true,
        ]); */
         User::create([
            'password' => Hash::make('Azerty54'),
            'email' => 'pierre.cordier3@wanadoo.fr',
            'name' => 'Pierre Cordier',
            'admin' => true,
        ]); 
    }

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};

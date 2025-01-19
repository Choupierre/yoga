<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* if (App::isLocal() && Schema::hasTable('users'))
  Auth::loginUsingId(1); */

Route::get('/', HomeController::class)->middleware(['auth'])->name('home');

require __DIR__ . '/auth.php';

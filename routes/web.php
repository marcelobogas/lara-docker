<?php

use App\Http\Controllers\BeerController;
use App\Mail\TesteEmail;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('sendEmail', function () {
    for ($i = 0; $i < 10; $i++) {
        Mail::to('teste@teste.com.br')
            ->queue(new TesteEmail);
    }
});

Route::group([
    'prefix'     => 'beers',
    'middleware' => 'auth'
], function () {

    Route::get('/', [BeerController::class, 'index'])->name('beers');

    Route::get('/export', [BeerController::class, 'export'])->name('beers-export');
});

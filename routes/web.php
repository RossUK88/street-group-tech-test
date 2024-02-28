<?php

use App\Facades\HomeOwner;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

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

Route::post('/dashboard', function (Request $request) {
    $request->validate([
        'csv' => ['required', 'file', 'mimes:csv']
    ]);

    $path = $request->file('csv')->store('uploads');

    $stream = Storage::readStream($path);

    $header = false;
    $people = [];
    while(($line = fgetcsv($stream)) !== false) {
        if(!$header) {
            $header = true;
            continue;
        }

        $people[] = HomeOwner::toArray($line[0]);
    }

    return Inertia::render('Dashboard', [
        'people' => $people,
    ]);
})->middleware(['auth', 'verified'])->name('upload');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', ['people' => []]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

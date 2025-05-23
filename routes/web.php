<?php
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Middleware\RoleMiddleware;

Route::middleware(['auth', 'role:asesor,admin'])->group(function () {
    Route::get('/home', [PostController::class, 'home'])->name('home');


    Route::prefix('estudios')->group(function () {
        Route::get('/show', [PostController::class, 'showStudy'])->name('posts.showStudy');
        Route::get('/create', [PostController::class, 'createEstudio'])->name('study.create');
        Route::post('/store', [PostController::class, 'storeStudy'])->name('study.store');
        Route::put('/{study}', [PostController::class, 'updateEstudio'])->name('study.update');
    });


    Route::prefix('posts')->group(function () {
        Route::get('/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/', [PostController::class, 'store'])->name('posts.store');
        Route::get('/', [PostController::class, 'index'])->name('posts.index');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        Route::put('/{post}/activar', [PostController::class, 'Activar'])->name('posts.activar');
        Route::put('/{post}/calibrar', [PostController::class, 'Calibrar'])->name('posts.calibrar');
        Route::put('/{post}/guardar', [PostController::class, 'Guardar'])->name('posts.guardar');

        // 🟡 ESTA DEBE IR AL FINAL del grupo "posts" porque es genérica
        Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');
    });


    Route::prefix('profile')->group(function () {
        Route::get('/create', [ProfileController::class, 'create'])->name('profile.create');
        Route::post('/', [ProfileController::class, 'store'])->name('profile.store');
        Route::get('/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/{user}', [ProfileController::class, 'show'])->name('profile.show');
    });

});


require __DIR__.'/auth.php';

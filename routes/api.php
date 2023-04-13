<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GenreController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware(['auth:api'])->group(function () {

    Route::apiResource('books', BookController::class);

    Route::apiResource('genres', GenreController::class);
    Route::get('booksByGenre/{genre_id}', [GenreController::class, 'filterByGenre']);

    Route::apiResource('roles', RoleController::class);
    Route::post('roles/switch/{user_id}', [RoleController::class, 'switchRole']);
    Route::get('users', [RoleController::class, 'ViewUsersRoles']);

});



Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('me', 'me');
    Route::post('profile/{user}', 'profileEdit');
    Route::post('forgot', 'forgot');
    Route::post('reset/{token}', 'reset')->name('reset.password.post');
});


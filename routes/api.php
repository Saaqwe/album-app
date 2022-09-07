<?php

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('albums', [\App\Http\Controllers\AlbumController::class, 'store']);
    Route::put('albums/{id}', [\App\Http\Controllers\AlbumController::class, 'update']);
    Route::post('album_info', [\App\Http\Controllers\LastFMController::class, 'showAlbumData']);
});


Route::post('albums/all', [\App\Http\Controllers\AlbumController::class, 'showAll']);





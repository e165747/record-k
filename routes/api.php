<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\RecordController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});
Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::get('/me', MeController::class);
  Route::post('/records/{record}/upsert-image', [RecordController::class, 'upsertImage']);
  Route::get('/records/get-records-by-author/{author}', [RecordController::class, 'getRecordsByAuthor']);
  Route::apiResource('/records', RecordController::class);
  Route::get('/authors/get-authors', [AuthorController::class, 'list']);
  Route::post('/authors/{author}/upsert-image', [AuthorController::class, 'upsertImage']);
  Route::apiResource('/authors', AuthorController::class);
});

<?php

/**
 * @SWG\Swagger(schemes={"http"}, basePath="/v1", @SWG\Info(version="1.0.0", title="Api Exemplo API"))
 */

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

/**
 * @SWG\Get(path="/produtos", summary="Lista todos os produtos", produces={"application/json"}, @SWG\Response(response="default", description="successful operation"), 
 * @SWG\Parameter(description="Pesquisa", in="query", name="like", required=false, type="string"))
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Api\AuthController@login');
Route::post('refresh', 'Api\AuthController@refresh');

Route::group(['middleware' => ['auth:api', 'jwt.refresh']], function () {

    Route::get('users', function () {
        return \App\User::all();
    });

    Route::post('logout', 'Api\AuthController@logout');
});

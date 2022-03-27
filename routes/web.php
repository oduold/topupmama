<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->get('books',  ['uses' => 'BookController@books']);
    $router->get('books/{id}',  ['uses' => 'BookController@book']);
    $router->get('documentation', function(){return view('swagger.index');});
    $router->get('books/{id}/comments',  ['uses' => 'BookController@bookComments']);    
    $router->get('books/{id}/characters',  ['uses' => 'BookController@bookCharacters']);
    $router->post('books/{id}/characters',  ['uses' => 'BookController@createBookCharacter']);
    $router->post('books/{id}/comments',  ['uses' => 'BookController@createBookComment']);
    $router->post('books',  ['uses' => 'BookController@create']);
    $router->put('books/{id}',  ['uses' => 'BookController@update']);
    $router->put('comments/{id}',  ['uses' => 'BookController@updateComment']);
    $router->put('characters/{id}',  ['uses' => 'CommentController@updateCharacter']);
    $router->delete('books/{id}',  ['uses' => 'CharacterController@delete']);
    $router->delete('comments/{id}',  ['uses' => 'CommentController@deleteComment']);
    $router->delete('characters/{id}',  ['uses' => 'CharacterController@deleteCharacter']);
});

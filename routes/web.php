<?php

/** @var \Laravel\Lumen\Routing\Router $router */
use Illuminate\Support\Facades\DB;


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

// $router->get('test', function () {
//     return 'Test route working!';
// });
// $router->get('/test-db', function () {
//     try {
//         \DB::connection()->getPdo();
//         return 'Database connected!';
//     } catch (\Exception $e) {
//         return 'Could not connect to the database. Please check your configuration.';
//     }
// });

$router->get('/', 'TaskController@index');
$router->get('tasks/trashed', 'TaskController@trashed');
$router->get('tasks/completed', 'TaskController@completed');
$router->get('tasks/not_completed', 'TaskController@uncomplete');
$router->get('tasks/{id}', 'TaskController@show');
$router->post('tasks', 'TaskController@store');
$router->put('tasks/{id}', 'TaskController@update');
$router->delete('tasks/{id}', 'TaskController@destroy');




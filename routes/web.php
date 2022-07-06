<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Stock;

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
    $router->get('products', 'ProductController@index');
    $router->get('product/{id}[/{getStock}]', 'ProductController@show');
    $router->post('product/create', 'ProductController@store');
    $router->put('product/update/{id}', 'ProductController@update');
    $router->delete('product/destroy/{id}', 'ProductController@destroy');
    $router->post('stock/create', 'StockController@store');
});

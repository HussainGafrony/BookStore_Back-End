<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//App Route

Route::post('/app/login', 'API\V1\UserController@login');

Route::get('/app/logout', 'API\V1\UserController@logout');

Route::post('/app/register', 'API\V1\UserController@register');

Route::middleware(['auth:api'])->group(function () {

    // test of notifying all user

    Route::get('/notify/{book}','API\V1\UserController@notifyUser');


//Category Route

    Route::get('/categories/index', 'API\V1\CategoryController@index');

    Route::post('/categories/store', 'API\V1\CategoryController@store');

    Route::get('/categories/show/{id}', 'API\V1\CategoryController@show');

    Route::post('/categories/update/{id}', 'API\V1\CategoryController@update');

//Book Route

    Route::get('/books/index', 'API\V1\BookController@index');

    Route::post('/books/store', 'API\V1\BookController@store');

    Route::get('/books/show/{id}', 'API\V1\BookController@show');

//Order Route

    Route::get('/orders/index', 'API\V1\OrderController@index');

    Route::post('/orders/store', 'API\V1\OrderController@store');

    Route::get('/orders/show/{id}', 'API\V1\OrderController@show');

    Route::get('/orders/delete/{id}', 'API\V1\OrderController@destroy');

//OrderItem Route

    Route::get('/orderitem/index', 'API\V1\OrderItemController@index');

    Route::post('/orderitem/store', 'API\V1\OrderItemController@store');

    Route::get('/orderitem/show/{id}', 'API\V1\OrderItemController@show');

    Route::get('/orderitem/delete/{id}', 'API\V1\OrderItemController@destroy');

    // get all item_order

    Route::get('/orderitem/getAllItems/{id}', 'API\V1\OrderItemController@getAllItems');

//get book where category id

    Route::get('/categories/getBookTypeCategory/{id}', 'API\V1\CategoryController@getBookTypeCategory');

    // get category of book

    Route::get('/books/showCategoryOfBook/{id}', 'API\V1\BookController@showCategoryOfBook');

    //search book
    Route::get('/books/searchBook/{something}', 'API\V1\BookController@searchBook');

    Route::get('/books/{something}', 'API\V1\UserController@notifyUser');

});

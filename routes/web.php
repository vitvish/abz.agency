<?php

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
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function(){

    // Route in resource controller for live search
    Route::get('/employee/search', 'EmployeeController@search')
        ->name('admin.search');

    // Route for create select
    Route::get('/employee/select', 'EmployeeController@getEmployeesForSelect')
        ->name('admin.select');

    // Resource controller for employees
    Route::resource('/employee', 'EmployeeController');
});

Route::get('/', function () {
    return view('welcome');
})->name('root');

Route::get('/all', function(App\Employee $employee){
    $all = $employee::all();
    $x = $all->load('position');
    echo json_encode($x);
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

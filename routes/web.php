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

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', 'App\Http\Controllers\AuthController@index');
Route::get('login2', 'App\Http\Controllers\AuthController@indexlogin2');
Route::get('login3', 'App\Http\Controllers\AuthController@indexlogin3');
// Route::get('moderator', 'AuthController@indexmoderator')->name('moderator');
Route::resource('products','App\Http\Controllers\ProductController');

Route::get('moderatorlogin', 'App\Http\Controllers\AuthController@indexmoderatorlogin');
Route::get('operatorlogin', 'App\Http\Controllers\AuthController@indexoperatorlogin');
Route::get('dashboard', 'App\Http\Controllers\AuthController@dashboard');
Route::get('dashboard2', 'App\Http\Controllers\AuthController@dashboard2');
Route::get('notfound', 'App\Http\Controllers\AuthController@notfound');
Route::get('userlist', 'App\Http\Controllers\AuthController@userlist');
// Route::get('show','AuthController@indexshow')->name('show');

Route::post('post-login', 'App\Http\Controllers\AuthController@postLogin');
Route::post('post-login2', 'App\Http\Controllers\AuthController@postLogin2');
Route::post('post-login3', 'App\Http\Controllers\AuthController@postLogin3');
Route::post('post-operator-login', 'App\Http\Controllers\AuthController@postoperatorLogin');  
Route::post('post-moderator-login', 'App\Http\Controllers\AuthController@postmoderatorLogin'); 
Route::get('logout', 'App\Http\Controllers\AuthController@logout');

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/contacts', 'App\Http\Controllers\ContactsController@get');
Route::get('/conversation/{id}', 'App\Http\Controllers\ContactsController@getMessagesFor');
Route::post('/conversation/send', 'App\Http\Controllers\ContactsController@send');

//enquiry
Route::get('contactus', 'App\Http\Controllers\EnquiryController@getContact');
Route::post('contactus', 'App\Http\Controllers\EnquiryController@saveContact');

//notification
Route::get('/notification/{id}', 'App\Http\Controllers\ContactsController@notification');

//list,add,update operator
Route::get('/listoperator', 'App\Http\Controllers\ContactsController@listoperator');
Route::get('/addoperator/{loginotp}/{password}/{lang}/{project}/{role}/{booth}/{welcometext}/{company}/{position}/{suggestion}/{image}', 'App\Http\Controllers\ContactsController@addoperator');
Route::get('/updateoperator/{loginotp}/{password}/{lang}/{project}/{role}/{booth}/{welcometext}', 'App\Http\Controllers\ContactsController@updateoperator');
Route::get('/deleteoperator/{loginotp}', 'App\Http\Controllers\ContactsController@deleteoperator');

//add new user
Route::get('/adduser/{name}/{email}/{company}/{position}/{suggestion}','App\Http\Controllers\AuthController@createnewuserapi');
Route::get('/updateuser/{email}/{loginotp}', 'App\Http\Controllers\AuthController@updateuser');
Route::get('/listuser', 'App\Http\Controllers\AuthController@listuser');
Route::get('/listexhibitor', 'App\Http\Controllers\AuthController@listexhibitor');
Route::get('/listsuggestion', 'App\Http\Controllers\AuthController@listsuggestion');

Route::get('/touchuser/{email}', 'App\Http\Controllers\AuthController@touchuser');
Route::get('/exportexcel', 'App\Http\Controllers\AuthController@export');

Route::get('/store-json', 'App\Http\Controllers\JsonController@store');
<?php



Route::get('/', function () {
    return view('welcome');
});

Route::auth();   // /login , /register

Route::post('/register','UserController@store'); // /register (uniquement lors de l'envoi du formulaire d'inscription)
Route::get('/home', 'HomeController@index');
// Créer un nouveau post
Route::get('/post/create','PostController@create');  // Lorsque l'url localhost/platform/public/post/create sera tapée, la classe PostController sera instanciée et sa méthode "create" appelée

Route::post('/post/create','PostController@store'); // Lorsque la page localhost/platform/public/post/create sera chargée via un envoi de formulaire, ce n'est plus la méthode create qui sera utilisée mais la méthode store
// Editer un post
Route::get('/post/{post}/edit', 'PostController@edit');  // {post} correspond au paramètre Post $post définit dans la méthode edit de la classe PostController.
// Lorsque l'on tape localhost/public/post/2/edit  alors le paramètre $post sera une instance de la classe Post correspondant au post ayant l'id 2 dans la table posts
Route::post('/post/{post}/edit','PostController@update');
Route::get('/posts','PostController@index'); // servira a lister tous les posts
Route::get('/advert/create','AdvertController@create');


Route::post('/user/{user}/edit','UserController@edit');

// route pour advert
Route::get('/advert/create','AdvertController@create');
Route::post('/advert/create','AdvertController@store');
Route::get('/advert/{advert}/edit','AdvertController@edit');
Route::post('/advert/{advert}/edit','AdvertController@update');
Route::get('/adverts','AdvertController@index');
Route::get('/advert/{advert}', 'AdvertController@show');


// Routes pour users
Route::get('/user/edit', 'UserController@edit');
Route::post('/user/edit', 'UserController@update');
Route::get('/users', 'UserController@index');
Route::get('/user/{user}', 'UserController@Show');

// Routes pour profile utilisateur

Route::get('/profile', 'ProfilController@profile');
Route::post('/profile', 'ProfilController@update');
Route::post('/profile/edit_password', 'ProfilController@update_pass');

Route::get('/user/rate/{user}', 'RateController@rate');


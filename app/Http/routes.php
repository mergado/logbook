<?php


Route::post("/_mergado/hook/", "HookController@index");

Route::group(['middleware' => ['web']], function () {

	Route::get('oauth2', ['uses' => 'OAuthController@token', 'as' => 'token']);
	Route::get('error', ['uses' => 'ErrorController@index', 'as' => 'error']);
	Route::get('404page', ['uses' => 'ErrorController@notFound', 'as' => '404']);
	Route::get('error/widget', ['uses' => 'ErrorController@widget', 'as' => 'errors.widget']);
	Route::get('eshop/{eshop_id}/auth', ['uses' => 'OAuthController@auth', 'as' => 'auth']);

	Route::get('/logout', function(){
		//invisible to normal user in mergado
		Session::flush();
	});

	Route::group([
			"prefix" => "eshop/{eshop_id}",
			"middleware" => "oauth"
	], function() {
		Route::get('/', 'EshopController@index');
	});

	Route::group([
			'prefix' => 'eshop/{eshop_id}/project/{project_id}',
			"middleware" => "oauth"
	], function () {
		Route::get('/', 'ProjectLogsController@index');
		Route::resource('/logs', 'ProjectLogsController');
		Route::get('/export', 'ProjectLogsController@export');
		Route::get('/deleteLink/{id}', 'ProjectLogsController@deleteLink');
	});

	Route::group([
			"prefix" => "widget/eshop/{eshop_id}",
			"middleware" => "oauth"
	], function() {
		Route::get('/project/{project_id}', 'WidgetController@projectWidget');
		Route::get('/', 'WidgetController@eshopWidget');
	});

});



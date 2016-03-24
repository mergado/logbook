<?php

/*
|--------------------------------------------------------------------------
| Detect The Application Environment
|--------------------------------------------------------------------------
|
| Laravel takes a dead simple approach to your application environments
| so you can just specify a machine name for the host that matches a
| given environment, then we will automatically detect it for you.
|
*/
$env = $app->detectEnvironment(function(){

	$appStage = getenv('MERGADO_APPCLOUD_APPSTAGE');

	if (!$appStage && preg_match('#srv\/([a-z]+)\/#', __DIR__, $match)) {
		$appStage = end($match);
	}

	if ($appStage == 'production') {
		$environment = 'production';
	} else if ($appStage == 'dev') {
		$environment = 'dev';
	} else {
		$environment = 'local';
	}

	file_exists(__DIR__ . '/../' . $environment . '.env');
	$dotenv = new Dotenv\Dotenv(__DIR__ . '/../', '.' . $environment . '.env'); // Laravel 5.2
	$dotenv->overload(); //this is important


});
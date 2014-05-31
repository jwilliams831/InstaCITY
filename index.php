<?php

require 'vendor/autoload.php';

require 'Slim/Slim.php';

require 'route.php';


\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();




$app->get('/', function () use ($app) {$app->render('home.php');})->name('home');

$app->get('/:city', function ($city) 
{
	include'header.php';
	route($city);
        include'footer.php';
	

});



$app->run();


?>



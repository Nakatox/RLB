<?php

require_once __DIR__.'/../vendor/autoload.php';

use Bramus\Router\Router;

$router = new Router();

$router->get('/admin', '\App\Controller\AdminController@User');
$router->get('/tournament/list', '\App\Controller\TournamentController@showTournaments');
$router->get('/classement/list', '\App\Controller\TournamentController@showClassements');


$router->run();

dump("aaaa");
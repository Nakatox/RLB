<?php

require_once __DIR__.'/../vendor/autoload.php';

use Bramus\Router\Router;

$router = new Router();

$router->get('/admin', '\App\Controller\AdminController@User');
$router->get('/login', '\App\Controller\LogController@Log');
$router->post('/login', '\App\Controller\LogController@Log');

// création de tournois coté admin
$router->get('/admin/tournament/create', '\App\Controller\TournamentController@createTournament');
$router->post('/admin/tournament/create', '\App\Controller\TournamentController@createTournament');


$router->run();

// dump("aaaa");
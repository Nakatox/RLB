<?php

require_once __DIR__.'/../vendor/autoload.php';

use Bramus\Router\Router;

session_start();

$router = new Router();

$router->get('/admin', '\App\Controller\AdminController@User');

$router->get('/login', '\App\Controller\LogController@Log');
$router->post('/login', '\App\Controller\LogController@Log');
$router->get('/register', '\App\Controller\RegisterController@register');
$router->post('/register', '\App\Controller\RegisterController@register');

// création de tournois coté admin
$router->get('/admin/tournament/create', '\App\Controller\TournamentController@createTournament');
$router->post('/admin/tournament/create', '\App\Controller\TournamentController@createTournament');

// liste de tournois
$router->get('/tournament/list', '\App\Controller\TournamentController@showTournaments');
$router->get('/classement/list', '\App\Controller\TournamentController@showClassements');



$router->run();

// dump("aaaa");
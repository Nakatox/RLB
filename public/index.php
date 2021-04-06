<?php

require_once __DIR__.'/../vendor/autoload.php';

use Bramus\Router\Router;

session_start();
if(empty($_SESSION['id'])){
    $_SESSION['id'] = "";
}


$router = new Router();

$router->get('/admin', '\App\Controller\AdminController@User');

$router->get('/login', '\App\Controller\LogController@Log');
$router->post('/login', '\App\Controller\LogController@Log');
$router->get('/register', '\App\Controller\RegisterController@register');
$router->post('/register', '\App\Controller\RegisterController@register');
$router->get('/disconnect', '\App\Controller\RegisterController@disconnect');

// création de tournois coté admin
$router->get('/admin/tournament/create', '\App\Controller\TournamentController@createTournament');
$router->post('/admin/tournament/create', '\App\Controller\TournamentController@createTournament');

//edition de tournois coté admin
$router->get('/admin/tournament/delete/{id}', '\App\Controller\TournamentController@deleteTournamentById');
$router->get('/admin/tournament/edit/{id}', '\App\Controller\TournamentController@editTournamentById');
$router->post('/admin/tournament/edit/{id}', '\App\Controller\TournamentController@editTournamentById');
$router->get('/admin/tournament/list', '\App\Controller\TournamentController@showTournamentByUser');

//déroulement d'un tournois coté admin
$router->get('/admin/tournament/{id}/manage', '\App\Controller\TournamentController@manageTournament');


// liste de tournois
$router->get('/tournament/list', '\App\Controller\TournamentController@showTournaments');
$router->get('/classement/list', '\App\Controller\TournamentController@showClassements');

//team
$router->get('/team/select/{id}', '\App\Controller\TeamController@showTeamById');
$router->get('/teams/all', '\App\Controller\TeamController@showTeams');
$router->get('/teams/all/like', '\App\Controller\TeamController@showSortLikes');
$router->get('/teams/all/win', '\App\Controller\TeamController@showSortWins');
$router->get('/create/teams', '\App\Controller\TeamController@showcreateTeamsForm');
$router->post('/create/teams', '\App\Controller\TeamController@showcreateTeamsForm');

//tournoi
$router->get('/tournament/classement/{id}', '\App\Controller\TournamentController@showClassement');
$router->get('/tournament/{id}/admin', '\App\Controller\TournamentController@tournamentByIdAdmin');
$router->get('/tournament/{id}', '\App\Controller\TournamentController@showTournamentById');




$router->run();

// dump("aaaa");
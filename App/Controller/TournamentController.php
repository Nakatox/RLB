<?php

namespace App\Controller;

use App\Model\StageModel;
use Cocur\Slugify\Slugify;
use App\Model\TournamentModel;

use App\Model\TeamModel;
use Framework\Controller;
require('Team.php');
require('Tournament.php');

class TournamentController extends Controller{

    public function showTournaments() {
        $tournamentModel = new TournamentModel();
        $tournaments = $tournamentModel->tournaments();
        $date = Date('Y-m-d');
        $this->renderTemplate('tournament-list.html.twig', [
            'tournaments' => $tournaments,
            'date'=>$date
        ]);
            return;
    }

    public function showClassements() {
        $tournamentModel = new TournamentModel();
        $classements = $tournamentModel->classements();

        $filtredClassements = [];

        foreach($classements as $classement) {
            if (isset($filtredClassements[$classement["tournament_id"]])) {
                array_push($filtredClassements[$classement["tournament_id"]], $classement);
            } else {
                $filtredClassements[$classement["tournament_id"]] = [];
                array_push($filtredClassements[$classement["tournament_id"]], $classement);
            }
        }

        $this->renderTemplate('classement-list.html.twig', [
            'filtredClassements' => $filtredClassements
            
            ]);
            
            
    }
   

    public function createTournament(){
        if($_SESSION['id']!=""){
            $tournament = new TournamentModel();
            $team = new TeamModel();
            $teams = $team->getTeam();
            $stage = new StageModel();
        
            if(!empty($_POST["name"]) && strlen($_POST['name']) > 4 && strlen($_POST['name']) < 100 && !empty($_POST["teamChosen"])){
                //les équipes font du 1v1 donc ondivise le nombre de participant par deux pour avoir le tot d'étapes 
                $nb_stage = count($_POST["teamChosen"])/2;
                $name = $_POST["name"];
                $teamChoose = $_POST["teamChosen"];
                $allteamsId = [];


                //On defini ici toutes les infos des equipe et du tournois en cours ou fini
                $data = [
                    'status'=>'in_progress',
                    'teams'=>[]
                ];

                $tournament->insertTournament(1,$name,$nb_stage);
                $id_tournament = $tournament->getTournamentId($_SESSION['id'],$name,$nb_stage); //Ici les id sont a 1 par defaut car pas encore de Session
                foreach ($teamChoose as $key => $value) {
                    $tournament->insertClassement($id_tournament[0]['id'], $value, 0, "in-progress");
                }
                foreach ($teamChoose as $key => $value) {
                    $teamid = $team->getTeamByName($teamChoose[$key]);
                    $tournament->addTournamentHasTeam($id_tournament[0]['id'],$teamid[0]['id']);
                    array_push($allteamsId,$teamid[0]['id']);
                }
                $stage->insertStage($id_tournament[0]['id'],1);

                    $id_stage = $stage->getStageByTournament($id_tournament[0]['id'],1);
                    $teamsIdChoose = [];
                for ($i=0; $i < $nb_stage; $i++) { 
                    $stage->insertRound($id_stage[0]['id'],$allteamsId[0],$allteamsId[1],$i);
                    for ($y=0; $y < 2; $y++) { 
                        // array_push($teamsIdChoose,$teamid);
                        unset($allteamsId[$y]);
                    }
                    array_values($allteamsId);
                    dump($allteamsId);
                }
            }
            $this->renderTemplate('admin-createTournament.html',[
                'teams'=>$teams,
            ]);
        }else{
            http_response_code(404);
            die();
        }
    }   
    public function showTournamentById($id){
        $tournament = new TournamentModel();
        $dataTournament = $tournament->TournamentById($id);
        $date = Date('Y-m-d');
        $this->renderTemplate('show-tournament.html',[
            'dataTournament'=>$dataTournament[0],
            'date'=>$date
        ]);
    }
    public function showClassement($id){
        $classement =new TournamentModel();
        $data = $classement->classementById($id);
        $json = json_encode($data);

        header('Content-type: application/json');
        echo $json;
    }
    public function showTournamentByUser(){
        if($_SESSION['id']!=""){
            $tournamentsModel = new TournamentModel();
            $tournaments = $tournamentsModel->getTournamentByIdUser($_SESSION['id']);
            $this->renderTemplate('admin-tournament-list.html',[
                'tournaments'=>$tournaments,
            ]);
        }else{
            http_response_code(404);
            die();
        }
    }
    public function editTournamentById($id){
        if($_SESSION['id']!=""){
            $tournamentsModel = new TournamentModel();
            if(!empty($_POST["name"]) && strlen($_POST['name']) > 4 && strlen($_POST['name']) < 100 && !empty($_POST["date"])){
                $tournaments = $tournamentsModel->editTournamentById($id, $_POST["name"],$_POST["date"] );
                header('Location:/admin/tournament/list');
            }

            $dataTournament = $tournamentsModel->TournamentById($id);
            $this->renderTemplate('admin-tournament-edit.html',[
                'tournaments'=>$dataTournament[0],
            ]);
        }else{
            http_response_code(404);
            die();
        }
    }
    public function deleteTournamentById($id){
        if($_SESSION['id']!=""){
            $tournamentsModel = new TournamentModel();
            $tournamentsModel->deleteTournamentHasTeam($id);
            $tournamentsModel->deleteClassement($id);
            $tournamentsModel->deleteTournamentById($id);
            header('Location:/admin/tournament/list');
        }else{
            http_response_code(404);
            die();
        }
    }

    public function manageTournament($id){
        if($_SESSION['id']!=""){
            

            $this->renderTemplate('admin-manage-tournament.html');
        }else{
            http_response_code(404);
            die();
        }
    }
   
}

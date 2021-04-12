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

    public function showTournaments():void {
        $tournamentModel = new TournamentModel();
        $tournaments = $tournamentModel->tournaments();
        $date = Date('Y-m-d');
        $this->renderTemplate('tournament-list.html.twig', [
            'tournaments' => $tournaments,
            'date'=>$date
        ]);
            return;
    }

    public function showClassements():void {
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
   

    public function createTournament():void{
        if($_SESSION['id']!=""){
            $tournament = new TournamentModel();
            $team = new TeamModel();
            $teams = $team->getTeam();
            $stage = new StageModel();
        
            if(!empty($_POST["name"]) && strlen($_POST['name']) > 4 && strlen($_POST['name']) < 100 && !empty($_POST["teamChosen"])){
                //les équipes font du 1v1 donc ondivise le nombre de participant par deux pour avoir le tot d'étapes 
                $nb_stage = count($_POST["teamChosen"])/2;
                $number_of_stage = 0;
                if(count($_POST["teamChosen"]) == 16){
                $number_of_stage = 4;
                    
                }else if(count($_POST["teamChosen"]) == 8){
                    $number_of_stage = 3;
                        
                }else if(count($_POST["teamChosen"]) == 4){
                    $number_of_stage = 2;
                        
                }
                $name = $_POST["name"];
                $teamChoose = $_POST["teamChosen"];
                $allteamsId = [];


                //On defini ici toutes les infos des equipe et du tournois en cours ou fini
                $data = [
                    'status'=>'in_progress',
                    'teams'=>[]
                ];

                $tournament->insertTournament($_SESSION['id'],$name,$number_of_stage);
                $id_tournament = $tournament->getTournamentId($_SESSION['id'],$name,$number_of_stage); //Ici les id sont a 1 par defaut car pas encore de Session
                foreach ($teamChoose as $key => $value) {
                    $tournament->insertClassement($id_tournament[0]['id'], $value, 0, "in-progress");
                }
                foreach ($teamChoose as $key => $value) {
                    $teamid = $team->getTeamByName($teamChoose[$key]);
                    $tournament->addTournamentHasTeam($id_tournament[0]['id'],$teamid[0]['id']);
                    array_push($allteamsId,$teamid[0]['id']);
                }
                $stage->insertStage($id_tournament[0]['id'],$number_of_stage);

                    $id_stage = $stage->getStageByTournament($id_tournament[0]['id'],$number_of_stage);
                    $teamsIdChoose = [];
                for ($i=0; $i < $nb_stage; $i++) { 
                    $stage->insertRound($id_stage[0]['id'],$allteamsId[0],$allteamsId[1],$i);
                    for ($y=0; $y < 2; $y++) { 
                        unset($allteamsId[$y]);
                    }
                    $allteamsId = array_values($allteamsId);
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
    public function showTournamentById(int $id):void{
        $tournament = new TournamentModel();
        $dataTournament = $tournament->TournamentById($id);
        $date = Date('Y-m-d');
        $this->renderTemplate('show-tournament.html',[
            'dataTournament'=>$dataTournament[0],
            'date'=>$date
        ]);
    }
    public function showClassement(int $id):void{
        $classement =new TournamentModel();
        $data = $classement->classementById($id);
        $json = json_encode($data);

        header('Content-type: application/json');
        echo $json;
    }
    public function showTournamentByUser():void{
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
    public function editTournamentById(int $id):void{
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
    public function deleteTournamentById(int $id):void{
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

    public function manageTournament(int $id):void{
        if($_SESSION['id']!=""){
            $allRounds = [];
            $stage4=[
                ['1'=>"",'2'=>""],
                ['1'=>"",'2'=>""],
                ['1'=>"",'2'=>""],
                ['1'=>"",'2'=>""],
                ['1'=>"",'2'=>""],
                ['1'=>"",'2'=>""],
                ['1'=>"",'2'=>""],
                ['1'=>"",'2'=>""],
            ];
            $stage3=[
                ['1'=>"",'2'=>""],
                ['1'=>"",'2'=>""],
                ['1'=>"",'2'=>""],
                ['1'=>"",'2'=>""],
            ];
            $stage2=[
                ['1'=>"",'2'=>""],
                ['1'=>"",'2'=>""],
            ];
            $stage1=[
                ['1'=>"",'2'=>""],
            ];
            $winner="";
            $tournamentModel = new TournamentModel();
            $stageModel = new StageModel();
            $teamModel = new TeamModel();
            $stage = new StageModel();

            $tournament = $tournamentModel->tournamentById($id);
            $allStages = $stageModel->getAllStageByTournament($id);
            for ($i=0; $i < count($allStages); $i++) { 
              array_push($allRounds,$stageModel->getRoundByStage($allStages[$i]['id']))  ;
            }
            for ($y=0; $y < count($allRounds); $y++) { 
                if(count($allRounds[$y]) == 8){
                    foreach($stage4 as $key =>$value){
                        $stage4[$key]['1'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_1']);
                        $stage4[$key]['2'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_2']);
                    }
                }else if(count($allRounds[$y]) == 4){
                    foreach($stage3 as $key =>$value){
                        $stage3[$key]['1'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_1']);
                        $stage3[$key]['2'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_2']);
                    }
                }else if(count($allRounds[$y]) == 2){
                    foreach($stage2 as $key =>$value){
                        $stage2[$key]['1'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_1']);
                        $stage2[$key]['2'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_2']);
                    }
                }else if(count($allRounds[$y]) == 1){
                    foreach($stage1 as $key =>$value){
                        $stage1[$key]['1'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_1']);
                        $stage1[$key]['2'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_2']);
                    }
                }
            }
            if(isset($_POST['round4-1'])){
                $stage->insertStage($id,4);
                $allteamsId = [$teamModel->getTeamByName2($_POST['round3-1']),$teamModel->getTeamByName2($_POST['round3-2']),$teamModel->getTeamByName2($_POST['round3-3']),$teamModel->getTeamByName2($_POST['round3-4'])];

                $id_stage = $stage->getStageByTournament($id,4);
                for ($i=0; $i < 4; $i++) { 
                    $stage->insertRound($id_stage[0]['id'],$allteamsId[0]['id'],$allteamsId[1]['id'],$i);
                    for ($y=0; $y < 2; $y++) { 
                        unset($allteamsId[$y]);
                    }
                    $allteamsId = array_values($allteamsId);
                }
            }
            if(isset($_POST['round3-1'])){
                $stage->insertStage($id,2);
                $allteamsId = [$teamModel->getTeamByName2($_POST['round3-1']),$teamModel->getTeamByName2($_POST['round3-2']),$teamModel->getTeamByName2($_POST['round3-3']),$teamModel->getTeamByName2($_POST['round3-4'])];

                $id_stage = $stage->getStageByTournament($id,2);
                for ($i=0; $i < 2; $i++) { 
                    $stage->insertRound($id_stage[0]['id'],$allteamsId[0]['id'],$allteamsId[1]['id'],$i);
                    for ($y=0; $y < 2; $y++) { 
                        unset($allteamsId[$y]);
                    }
                    $allteamsId = array_values($allteamsId);
                }
            }
            if(isset($_POST['round2-1'])){
                $stage->insertStage($id,1);
                $allteamsId = [$teamModel->getTeamByName2($_POST['round2-1']),$teamModel->getTeamByName2($_POST['round2-2'])];

                $id_stage = $stage->getStageByTournament($id,1);
                for ($i=0; $i < 1; $i++) { 
                    $stage->insertRound($id_stage[0]['id'],$allteamsId[0]['id'],$allteamsId[1]['id'],$i);
                    for ($y=0; $y < 2; $y++) { 
                        unset($allteamsId[$y]);
                    }
                    $allteamsId = array_values($allteamsId);
                }
            }

            if(isset($_POST['round1-1'])){
                $idTeam = $teamModel->getTeamByName2($_POST['round1-1']);
                $tournamentModel->insertWinner($id, $teamModel->getNameTeamById($idTeam['id']));
            }
            $winner = $tournamentModel->getWinner($id);
            $this->renderTemplate('admin-manage-tournament.html',[
                'tournament'=>$tournament[0],
                'allRounds'=>$allRounds,
                'round4'=>$stage4,
                'round3'=>$stage3,
                'round2'=>$stage2,
                'round1'=>$stage1,
                'winner'=>$winner[0]['winner']
            ]);
        }else{
            http_response_code(404);
            die();
        }
    }
    public function showTournament(int $id):void{
        $allRounds = [];
        $stage4=[
            ['1'=>"",'2'=>""],
            ['1'=>"",'2'=>""],
            ['1'=>"",'2'=>""],
            ['1'=>"",'2'=>""],
            ['1'=>"",'2'=>""],
            ['1'=>"",'2'=>""],
            ['1'=>"",'2'=>""],
            ['1'=>"",'2'=>""],
        ];
        $stage3=[
            ['1'=>"",'2'=>""],
            ['1'=>"",'2'=>""],
            ['1'=>"",'2'=>""],
            ['1'=>"",'2'=>""],
        ];
        $stage2=[
            ['1'=>"",'2'=>""],
            ['1'=>"",'2'=>""],
        ];
        $stage1=[
            ['1'=>"",'2'=>""],
        ];
        $winner="";
        $tournamentModel = new TournamentModel();
        $stageModel = new StageModel();
        $teamModel = new TeamModel();
        $stage = new StageModel();

        $tournament = $tournamentModel->tournamentById($id);
        $allStages = $stageModel->getAllStageByTournament($id);
        for ($i=0; $i < count($allStages); $i++) { 
            array_push($allRounds,$stageModel->getRoundByStage($allStages[$i]['id']))  ;
        }
        for ($y=0; $y < count($allRounds); $y++) { 
            if(count($allRounds[$y]) == 8){
                foreach($stage4 as $key =>$value){
                    $stage4[$key]['1'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_1']);
                    $stage4[$key]['2'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_2']);
                }
            }else if(count($allRounds[$y]) == 4){
                foreach($stage3 as $key =>$value){
                    $stage3[$key]['1'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_1']);
                    $stage3[$key]['2'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_2']);
                }
            }else if(count($allRounds[$y]) == 2){
                foreach($stage2 as $key =>$value){
                    $stage2[$key]['1'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_1']);
                    $stage2[$key]['2'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_2']);
                }
            }else if(count($allRounds[$y]) == 1){
                foreach($stage1 as $key =>$value){
                    $stage1[$key]['1'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_1']);
                    $stage1[$key]['2'] = $teamModel->getNameTeamById($allRounds[$y][$key]['team_2']);
                }
            }
        }
        $winner = $tournamentModel->getWinner($id);
        $this->renderTemplate('show-tournament2.html',[
            'tournament'=>$tournament[0],
            'allRounds'=>$allRounds,
            'round4'=>$stage4,
            'round3'=>$stage3,
            'round2'=>$stage2,
            'round1'=>$stage1,
            'winner'=>$winner[0]['winner']
        ]);
    }
   
}

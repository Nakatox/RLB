<?php

namespace App\Controller;

use Cocur\Slugify\Slugify;
use App\Model\TournamentModel;

use App\Model\TeamModel;
use Framework\Controller;


class TournamentController extends Controller{

    public function showTournaments() {
        $tournamentModel = new TournamentModel();
        $tournaments = $tournamentModel->tournaments();
        $this->renderTemplate('tournament-list.html.twig', [
            'tournaments' => $tournaments
            
            ]);
            return;
    }

    public function showClassements() {
        $tournamentModel = new TournamentModel();
        $classements = $tournamentModel->classements();
        $this->renderTemplate('classement-list.html.twig', [
            'classements' => $classements
            
            ]);
            return;
    }

    public function createTournament(){
        $tournament = new TournamentModel();
        $team = new TeamModel();
        $teams = $team->getTeam();
    
        // A sécuriser bien mieux que ca  
        if(!empty($_POST["name"]) && !empty($_POST["teamChosen"])){
            //les équipes font du 1v1 donc ondivise le nombre de participant par deux pour avoir le tot d'étapes 
            $nb_stage = count($_POST["teamChosen"])/2;
            $name = $_POST["name"];
            $teamChoose = $_POST["teamChosen"];


            //On defini ici toutes les infos des equipe et du tournois en cours ou fini
            $data = [
                'status'=>'in_progress',
                'teams'=>[]
            ];

            $tournament->insertTournament(1,$name,$nb_stage);
            $id_tournament = $tournament->getTournamentId(1,$name,$nb_stage); //Ici les id sont a 1 par defaut car pas encore de Session
            foreach ($teamChoose as $key => $value) {
                $tournament->insertClassement($id_tournament[0]['id'], $value, 0, "in-progress");
            }
            foreach ($teamChoose as $key => $value) {
                $teamid = $team->getTeamByName($teamChoose[$key]);
                $tournament->addTournamentHasTeam($id_tournament[0]['id'],$teamid[0]['id']);
            }
            
            

           
        }
        $this->renderTemplate('admin-createTournament.html',[
            'teams'=>$teams,
        ]);
    }   
    public function showTournamentById($id){
        $tournament = new TournamentModel();
        $dataTournament = $tournament->TournamentById($id);
        $this->renderTemplate('show-tournament.html',[
            'dataTournament'=>$dataTournament[0],
        ]);
    }
    public function showClassement($id){
        $classement =new TournamentModel();
        $data = $classement->classementById($id);
        $json = json_encode($data);

        header('Content-type: application/json');
        echo $json;
    }
}

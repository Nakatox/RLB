<?php

namespace App\Controller;

use Cocur\Slugify\Slugify;
use App\Model\TournamentModel;
use App\Model\TeamModel;
use Framework\Controller;


class TournamentController extends Controller{

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
            foreach ($teamChoose as $key => $value) {
                $data['teams'] += [
                    $key =>[
                        'team'=>$value,
                        'score'=>0,
                        'status'=>'in_progress',
                    ]
                ];
            }
            //on l'encode pour pouvoir le mettre dans la BDD
            $json = json_encode($data);
            //et ensuite on devra decode pour pouvoir utiliser/modifier pendant/apres le tournois
            // $jsondecode = json_decode($json);    
            // $jsondecode->status = "finish";         <----Exemples
            // dump($jsondecode) ;


            //
            $tournament->insertTournament(1,$name,$nb_stage);
            $id_tournament = $tournament->getTournamentId(1,$name,$nb_stage); //Ici les id sont a 1 par defaut car pas encore de Session
            $tournament->insertClassement($id_tournament[0]['id'],$json);
            foreach ($teamChoose as $key => $value) {
                $teamid = $team->getTeamByName($teamChoose[$key]);
                $tournament->addTournamentHasTeam($id_tournament[0]['id'],$teamid[0]['id']);
            }
        }
        $this->renderTemplate('admin-createTournament.html',[
            'teams'=>$teams,
        ]);
    }   
}
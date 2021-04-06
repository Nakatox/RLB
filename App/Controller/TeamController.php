<?php

namespace App\Controller;

use Cocur\Slugify\Slugify;
// use App\Model\TournamentModel;

use App\Model\TeamModel;
use Framework\Controller;


class TeamController extends Controller{
    private $teamModel;
    
    
    public function  __construct() 
    {
        parent::__construct();
        $this->teamModel = new TeamModel();
        
        
    }
    
    public function showTeamById($id){
        $teamModel = new TeamModel();
        $team = $teamModel->getTeamById($id);
        $this->renderTemplate('show-team.html',[
            'team'=>$team[0],
            ]);
    }
        
        public function showTeams(){
            $teamModel = new TeamModel();
            $teams = $teamModel->getTeam();
            $this->renderTemplate('show-all-teams.html',[
                'teams'=>$teams,
                ]);
        }
            
            public function showcreateTeamsForm()
            {
                
                if (isset($_POST['name'])  && isset($_POST['members'] ) && isset($_POST['nb_victory'] ) && isset($_POST['nb_likes']) ) {
                    $this->teamModel->createTeams($_POST['name'], $_POST['members'], $_POST['nb_victory'], $_POST['nb_likes']);
                    
                }
                
                $this->renderTemplate('create-teams.html.twig', [
                    
                    ]);
                    return;
                    
                    
                    
                    
            }
}
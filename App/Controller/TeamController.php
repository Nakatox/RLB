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
    public function getLike($id){
        $like_bd = new TeamModel();
        $likes = $like_bd->getLikes($id);

        $data = [
            'count' => $likes
        ];

        $json = json_encode($data);
        
        header('Content-type: application/json');

        echo $json;
    }
    public function addLike($id){
        $like_bd = new TeamModel();
        $likes = $like_bd->addLike($id);
        $data = [
            'status' => $likes,
        ];

        $json = json_encode($data);
        
        header('Content-type: application/json');

        echo $json;
    }
    public function removeLike($id){
        $like = new TeamModel();
        $likes = $like->removeLike($id);
        $data = [
            'status' => $likes,
        ];

        $json = json_encode($data);
        
        header('Content-type: application/json');

        echo $json;
    }

    public function showTeamById(int $id):void{
        $teamModel = new TeamModel();
        $team = $teamModel->getTeamById($id);
        $this->renderTemplate('show-team.html',[
            'team'=>$team[0],
        ]);
    }

    public function showTeams():void{
        $teamModel = new TeamModel();
        $teams = $teamModel->getTeam();
        $this->renderTemplate('show-all-teams.html',[
            'teams'=>$teams,
        ]);
    }

    public function showSortLikes():void{
        $teamModel = new TeamModel();
        $teams = $teamModel->sortLike();
        $this->renderTemplate('show-all-teams.html',[
            'teams'=>$teams,
        ]);
    }

    public function showSortWins():void{
        $teamModel = new TeamModel();
        $teams = $teamModel->sortWin();
        $this->renderTemplate('show-all-teams.html',[
            'teams'=>$teams,
        ]);
    }

    public function showcreateTeamsForm()
    {
        
        if (isset($_POST['name'])  && isset($_POST['members'] ) ) {
            $this->teamModel->createTeams($_POST['name'], $_POST['members']);
            
        }
        
        $this->renderTemplate('create-teams.html.twig', [
            
            ]);
            return;
            
            
    }
}
<?php

namespace App\Controller;

use Cocur\Slugify\Slugify;
// use App\Model\TournamentModel;

use App\Model\TeamModel;
use Framework\Controller;


class TeamController extends Controller{


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

    public function showSortLikes(){
        $teamModel = new TeamModel();
        $teams = $teamModel->sortLike();
        $this->renderTemplate('show-all-teams.html',[
            'teams'=>$teams,
        ]);
    }

    public function showSortWins(){
        $teamModel = new TeamModel();
        $teams = $teamModel->sortWin();
        $this->renderTemplate('show-all-teams.html',[
            'teams'=>$teams,
        ]);
    }
}
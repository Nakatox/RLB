<?php

namespace App\Model;


use Framework\Model;
use \PDO;

class StageModel extends Model{


    public function insertRound($stage_id,$team_1,$team_2,$round_number){
        $db = $this->getDb();
        $query = $db->prepare('INSERT INTO `round`(`stage_id`, `team_1`, `team_2`, `round_number`) VALUES (:stage_id,:team_1,:team_2,:round_number)');
        $query->execute( [
            'stage_id' => $stage_id,
	    	'team_1' => $team_1,
	    	'team_2' => $team_2,
	    	'round_number' => $round_number
        ]);
    }
    public function insertStage($tournament_id,$stage_number){
        $db = $this->getDb();
        $query = $db->prepare('INSERT INTO `stage`(`tournament_id`, `stage_number`) VALUES (:tournament_id,:stage_number)');
        $query->execute( [
            'tournament_id' => $tournament_id,
	    	'stage_number' => $stage_number
        ]);
    }
    public function getStageByTournament($tournament_id,$number){
        $db = $this->getDb();
        $query = $db->prepare('SELECT * FROM `stage` WHERE tournament_id = :tournament_id AND stage_number = :number');
        $query->execute( [
            'tournament_id' => $tournament_id,
            'number' => $number
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllStageByTournament($tournament_id){
        $db = $this->getDb();
        $query = $db->prepare('SELECT * FROM `stage` WHERE tournament_id = :tournament_id');
        $query->execute( [
            'tournament_id' => $tournament_id,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoundByStage($stage_id){
        $db = $this->getDb();
        $query = $db->prepare('SELECT * FROM `round` WHERE stage_id = :stage_id');
        $query->execute( [
            'stage_id' => $stage_id
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}

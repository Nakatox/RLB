<?php

namespace App\Model;


use Framework\Model;
use \PDO;

class StageModel extends Model{


    public function insertRound(int $stage_id,int $team_1,int $team_2,int $round_number){
        $db = $this->getDb();
        $query = $db->prepare('INSERT INTO `round`(`stage_id`, `team_1`, `team_2`, `round_number`) VALUES (:stage_id,:team_1,:team_2,:round_number)');
        $query->execute( [
            'stage_id' => $stage_id,
	    	'team_1' => $team_1,
	    	'team_2' => $team_2,
	    	'round_number' => $round_number
        ]);
    }
    public function insertStage(int $tournament_id, int $stage_number){
        $db = $this->getDb();
        $query = $db->prepare('INSERT INTO `stage`(`tournament_id`, `stage_number`) VALUES (:tournament_id,:stage_number)');
        $query->execute( [
            'tournament_id' => $tournament_id,
	    	'stage_number' => $stage_number
        ]);
    }
    public function getStageByTournament(int $tournament_id,int $number){
        $db = $this->getDb();
        $query = $db->prepare('SELECT * FROM `stage` WHERE tournament_id = :tournament_id AND stage_number = :number');
        $query->execute( [
            'tournament_id' => $tournament_id,
            'number' => $number
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllStageByTournament(int $tournament_id):array{
        $db = $this->getDb();
        $query = $db->prepare('SELECT * FROM `stage` WHERE tournament_id = :tournament_id');
        $query->execute( [
            'tournament_id' => $tournament_id,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoundByStage(int $stage_id):array{
        $db = $this->getDb();
        $query = $db->prepare('SELECT * FROM `round` WHERE stage_id = :stage_id');
        $query->execute( [
            'stage_id' => $stage_id
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteRounds(int $id):void{
        $db = $this->getDb();
        $query = $db->prepare('DELETE FROM `round` WHERE stage_id = :id');
        $query->execute( [
            'id' => $id,
        ]);
    }
    public function deleteStages(int $id):void{
        $db = $this->getDb();
        $query = $db->prepare('DELETE FROM `stage` WHERE tournament_id = :id');
        $query->execute( [
            'id' => $id,
        ]);
    }
}

<?php

namespace App\Model;


use Framework\Model;
use \PDO;

class TournamentModel extends Model{

public function tournaments()
    {
        $db = $this->getDb();
        $query = $db->prepare('SELECT * FROM tournament');
        $query->execute( [
           

    ]);
        $tournaments = $query->fetchAll();
        return $tournaments;
    }




    public function classements()
    {
        $db = $this->getDb();
        $query = $db->prepare('SELECT * FROM classement');
        $query->execute( [
           

    ]);
        $classements = $query->fetchAll();
        return $classements;
    }

    public function getTournament(){
        $db = $this->getDb();
        $stmt = $db->query('SELECT * FROM tournament');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTournamentId($user_id,$name,$nb_stage){
        dump($nb_stage);
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * FROM tournament WHERE user_id = :user_id AND name = :name AND nb_stage = :nb_stage');
        $stmt->execute([
            'user_id'=>$user_id,
            'name'=>$name,
            'nb_stage'=>$nb_stage
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertTournament($userid,$name,$nb_stage){
        $db = $this->getDb();
        $stmt = $db->prepare('INSERT INTO `tournament`(`user_id`, `name`, `nb_stage`) VALUES (:user_id,:name,:nb_stage)');
        $stmt->execute([
            'user_id'=>$userid,
            'name'=>$name,
            'nb_stage'=>$nb_stage
        ]);
    }
     
    public function insertClassement($id_tournament,$data){
        $db = $this->getDb();
        $stmt = $db->prepare('INSERT INTO `classement`(`data`, `tournament_id`) VALUES (:data,:id_tournament)');
        $stmt->execute([
            'data'=>$data,
            'id_tournament'=>$id_tournament
        ]);
    }
    public function addTournamentHasTeam($tournament_id,$team_id){
        $db = $this->getDb();
        $stmt = $db->prepare('INSERT INTO `tournaments_has_team`(`team_id`, `tournaments_id`) VALUES (:team_id,:tournament_id)');
        $stmt->execute([
            'team_id'=>$team_id,
            'tournament_id'=>$tournament_id
        ]);
    }

}

?>

    

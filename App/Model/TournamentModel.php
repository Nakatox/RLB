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
        $query = $db->prepare('SELECT * FROM classement ORDER BY score DESC');
        $query->execute( [
           

    ]);
        $classements = $query->fetchAll();
        return $classements;
    }

    public function getTournament():array{
        $db = $this->getDb();
        $stmt = $db->query('SELECT * FROM tournament');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTournamentId(int $user_id,string $name,int $nb_stage):array{
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * FROM tournament WHERE user_id = :user_id AND name = :name AND nb_stage = :nb_stage');
        $stmt->execute([
            'user_id'=>$user_id,
            'name'=>$name,
            'nb_stage'=>$nb_stage
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTournamentByIdUser(int $user_id):array{
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * FROM tournament WHERE user_id = :user_id ');
        $stmt->execute([
            'user_id'=>$user_id,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteTournamentById(int $id):void{
        $db = $this->getDb();
        $stmt = $db->prepare('DELETE FROM `tournament` WHERE id = :id');
        $stmt->execute([
            'id'=>$id,
        ]);
    }
    public function editTournamentById(int $id, string $name, $date):void{
        $db = $this->getDb();
        $stmt = $db->prepare('UPDATE `tournament` SET `name`=:name,`date`=:date WHERE id = :id');
        $stmt->execute([
            'id'=>$id,
            'name'=>$name,
            'date'=>$date,
        ]);
    }


    public function insertTournament(int $userid,string $name,int $nb_stage):void{
        $db = $this->getDb();
        $stmt = $db->prepare('INSERT INTO `tournament`(`user_id`, `name`, `nb_stage`) VALUES (:user_id,:name,:nb_stage)');
        $stmt->execute([
            'user_id'=>$userid,
            'name'=>$name,
            'nb_stage'=>$nb_stage
        ]);
    }
     
    public function insertClassement(int $id_tournament,string $name,int $score,string $status):void{
        $db = $this->getDb();
        $stmt = $db->prepare('INSERT INTO `classement`(`team`,`score`,`status`,`tournament_id`) VALUES (:team,:score,:status,:id_tournament)');
        $stmt->execute([
            'team'=>$name,
            'score'=>$score,
            'status'=>$status,
            'id_tournament'=>$id_tournament
        ]);
    }
    public function deleteClassement(int $id):void{
        $db = $this->getDb();
        $stmt = $db->prepare('DELETE FROM `classement` WHERE tournament_id=:id');
        $stmt->execute([
            'id'=>$id,
        ]);
    }
    public function addTournamentHasTeam(int $tournament_id,int $team_id):void{
        $db = $this->getDb();
        $stmt = $db->prepare('INSERT INTO `tournaments_has_team`(`team_id`, `tournaments_id`) VALUES (:team_id,:tournament_id)');
        $stmt->execute([
            'team_id'=>$team_id,
            'tournament_id'=>$tournament_id
        ]);
    }
    public function deleteTournamentHasTeam(int $tournament_id):void{
        $db = $this->getDb();
        $stmt = $db->prepare('DELETE FROM `tournaments_has_team` WHERE tournaments_id=:tournament_id');
        $stmt->execute([
            'tournament_id'=>$tournament_id
        ]);
    }

    public function tournamentById(int $id):array{
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * FROM tournament WHERE id = :id');
        $stmt->execute([
            'id'=>$id,
        ]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function classementById(int $id):array{
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * FROM classement WHERE tournament_id = :id ORDER BY score');
        $stmt->execute([
            'id'=>$id,
        ]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function insertWinner(int $id,string $team):void{
        $db = $this->getDb();
        $stmt = $db->prepare('UPDATE `tournament` SET `winner`=:team WHERE id = :id');
        $stmt->execute([
            'id'=>$id,
            'team'=>$team
        ]);
    }

    public function getWinner(int $id):array{
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT `winner` FROM `tournament` WHERE id = :id');
        $stmt->execute([
            'id'=>$id,
        ]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    
}

?>

    

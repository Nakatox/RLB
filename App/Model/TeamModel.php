<?php

namespace App\Model;


use Framework\Model;
use \PDO;

class TeamModel extends Model{

    public function getTeam(){
        $db = $this->getDb();
        $stmt = $db->query('SELECT * FROM team');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function sortLike(){
        $db = $this->getDb();
        $stmt = $db->query('SELECT * FROM `team` ORDER BY `nb_likes` + 0 DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function sortWin(){
        $db = $this->getDb();
        $stmt = $db->query('SELECT * FROM `team` ORDER BY `nb_victory` + 0 DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTeamByName($name){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT id FROM team WHERE name = :name');
        $stmt->execute([
            'name'=>$name,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTeamByName2($name){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT id FROM team WHERE name = :name');
        $stmt->execute([
            'name'=>$name,
        ]);
        $team = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $team[0];
    }
    public function getTeamById($id){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * FROM team WHERE id = :id');
        $stmt->execute([
            'id'=>$id,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getNameTeamById($id){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT name FROM team WHERE id = :id');
        $stmt->execute([
            'id'=>$id,
        ]);
        $team = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $team[0]['name'];
    }
    public function getNameTeamById2($id){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT name FROM team WHERE id = :id');
        $stmt->execute([
            'id'=>$id,
        ]);
        $team = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $team;
    }

    public function createTeams($name, $members)
    {
        $db = $this->getDb();
        $query = $db->prepare('INSERT INTO team (`name`, `members`) VALUES (:name, :members)');
        $query->execute( [
            'name' => $name,
	    	'members' => $members
    ]);
  
    }
}
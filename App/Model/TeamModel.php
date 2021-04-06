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
    public function getTeamByName($name){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT id FROM team WHERE name = :name');
        $stmt->execute([
            'name'=>$name,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTeamById($id){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * FROM team WHERE id = :id');
        $stmt->execute([
            'id'=>$id,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTeams($name, $members, $nb_victory, $nb_likes)
    {
        $db = $this->getDb();
        $query = $db->prepare('INSERT INTO team (`name`, `members`, `nb_victory`, `nb_likes`) VALUES (:name, :members, :nb_victory, :nb_likes)');
        $query->execute( [
            'name' => $name,
	    	'members' => $members,
	    	'nb_victory' => $nb_victory,
            'nb_likes' => $nb_likes,
           

    ]);
  
    }
}
<?php

namespace App\Model;


use Framework\Model;
use \PDO;

class TeamModel extends Model{

    public function getTeam():array{
        $db = $this->getDb();
        $stmt = $db->query('SELECT * FROM team');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function sortLike():array{
        $db = $this->getDb();
        $stmt = $db->query('SELECT * FROM `team` ORDER BY `nb_likes` + 0 DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function sortWin():array{
        $db = $this->getDb();
        $stmt = $db->query('SELECT * FROM `team` ORDER BY `nb_victory` + 0 DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTeamByName(string $name):array{
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT id FROM team WHERE name = :name');
        $stmt->execute([
            'name'=>$name,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTeamByName2(string $name):array{
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT id FROM team WHERE name = :name');
        $stmt->execute([
            'name'=>$name,
        ]);
        $team = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $team[0];
    }
    public function getTeamById(int $id){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * FROM team WHERE id = :id');
        $stmt->execute([
            'id'=>$id,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getNameTeamById(int $id):string{
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT name FROM team WHERE id = :id');
        $stmt->execute([
            'id'=>$id,
        ]);
        $team = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $team[0]['name'];
    }
    public function getNameTeamById2(int $id):array{
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT name FROM team WHERE id = :id');
        $stmt->execute([
            'id'=>$id,
        ]);
        $team = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $team;
    }

    public function createTeams(string $name, string $members)
    {
        $db = $this->getDb();
        $query = $db->prepare('INSERT INTO team (`name`, `members`) VALUES (:name, :members)');
        $query->execute( [
            'name' => $name,
	    	'members' => $members
    ]);
  
    }
}
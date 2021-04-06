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
    public function getTeamById($id){
        $db = $this->getDb();
        $stmt = $db->prepare('SELECT * FROM team WHERE id = :id');
        $stmt->execute([
            'id'=>$id,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
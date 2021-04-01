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
            ':name'=>$name,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
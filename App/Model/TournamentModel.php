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



}

?>
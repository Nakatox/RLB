<?php

namespace App\Model;


use Framework\Model;
use \PDO;

class UserModel extends Model{

    public function getUser(){
        $db = $this->getDb();
        $stmt = $db->query('SELECT * FROM user');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
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

    public function getAllUser(string $firstname, string $lastname, $email, string $password)
    {
        $db = $this->getDb();
        $requete = $db->prepare('SELECT * FROM `user` WHERE first_name = :firstname AND last_name = :lastname AND email = :email AND password = :password');
        $requete->execute([
            ':firstname' => $firstname, 
            ':lastname' => $lastname, 
            ':email' => $email, 
            ':password' => $password
        ]);
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }
}
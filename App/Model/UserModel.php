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

    public function checkUser($email, string $password)
    {
        $db = $this->getDb();
        $requete = $db->prepare('SELECT * FROM `user` WHERE email = :email AND password = :password');
        $requete->execute([
            'email' => $email, 
            'password' => $password
        ]);
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser(string $firstname, string $lastname, $email, string $password)
    {
        $db = $this->getDb();
        $stmt = $db->prepare('INSERT INTO `user`(`first_name`, `last_name`, `email`, `password`) VALUES (:first_name,:last_name,:email,:password)');
        $stmt->execute([
            'first_name'=>$firstname,
            'last_name'=>$lastname,
            'email'=>$email,
            'password'=>$password
        ]);
    }
}
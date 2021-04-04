<?php

namespace App\Controller;

class Tournament {

    private $status;
    private $teams;
    private $id;

    public function __construct($status, $teams, $id)
    {
        $this->status = $status;
        $this->teams = $teams;
        $this->id = $id;
    }

    public function getStatus() 
    {
        return $this->status;
    }
    public function setStatus($status) 
    {
        $this->status = $status;
    }


    public function getTeams() 
    {
        return $this->teams;
    }
    public function setTeams($teams) 
    {
        $this->teams = $teams;
    }
    public function getId() 
    {
        return $this->id;
    }
    public function setId($id) 
    {
        $this->id = $id;
    }
}



?>
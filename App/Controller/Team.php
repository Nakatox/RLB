<?php

namespace App\Controller;

class Team {

    private $name;
    private $score;

    public function __construct($name, $score)
    {
        $this->name = $name;
        $this->score = $score;
    }

    public function getname() 
    {
        return $this->name;
    }
    public function setname($name) 
    {
        $this->name = $name;
    }


    public function getscore() 
    {
        return $this->score;
    }
    public function setscore($score) 
    {
        $this->score = $score;
    }
}

?>
<?php


namespace App\Controller;

use Cocur\Slugify\Slugify;
use App\Model\UserModel;
use Framework\Controller;


class LogController extends Controller{

    public function Log():void{

        $this->renderTemplate('login.html');

        if (isset($_POST['email']) && strlen($_POST['email'])>3 && isset($_POST['password']) && strlen($_POST['password'])>3 && strlen($_POST['password'])<20) 
        {
            $userModel = new UserModel();
            $password = $userModel->getUserPassword($_POST['email']);

            if(password_verify($_POST['password'],$password[0]['password'])){
                $user = $userModel->checkUser($_POST['email'], $password[0]['password']);
            }
            if ($user)
            {
                $_SESSION['id'] = $user[0]["id"];
                header('Location: /admin/tournament/create');
            }
        }
    }
}
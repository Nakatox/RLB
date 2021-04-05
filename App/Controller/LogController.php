<?php


namespace App\Controller;

use Cocur\Slugify\Slugify;
use App\Model\UserModel;
use Framework\Controller;


class LogController extends Controller{

    public function Log(){

        $this->renderTemplate('login.html');

        if (isset($_POST['email']) && strlen($_POST['email'])>3 && isset($_POST['password']) && strlen($_POST['password'])>3 && strlen($_POST['password'])<20) 
        {
            $userModel = new UserModel();
            $user = $userModel->checkUser($_POST['email'], $_POST['password'] );

            if ($user)
            {
                $_SESSION['id'] = $user[0]["id"];
                header('Location: /admin/tournament/create');
            }
        }
    }
}
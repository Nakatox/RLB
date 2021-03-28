<?php


namespace App\Controller;

use Cocur\Slugify\Slugify;
use App\Model\UserModel;
use Framework\Controller;


class LogController extends Controller{

    public function Log(){

        $this->renderTemplate('login.html');

        if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['password'])) 
        {
            session_start();
            $userModel = new UserModel();
            $user = $userModel->getUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password']);
            dump($user);

            if ($user)
            {
                echo "nice";
                $_SESSION['firstname'] = $_POST['firstname'];
                echo "<h1>" . $_SESSION['firstname'] . "</h1>";
            } 
        } else {
            echo "error";
        }
    }
}
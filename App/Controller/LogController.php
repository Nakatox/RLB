<?php


namespace App\Controller;

use Cocur\Slugify\Slugify;
use App\Model\UserModel;
use Framework\Controller;


class LogController extends Controller{

    public function Log(){

        $this->renderTemplate('login.html');

        if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password'])) 
        {
            $userModel = new UserModel();
            $user = $userModel->getAllUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'] );
            var_dump($user);

            if ($user)
            {
                $_SESSION['firstname'] = $_POST['firstname'];
                var_dump($_SESSION['firstname']);
                echo "<h1>" . $_SESSION['firstname'] . "</h1>";
            } 
        } else {
            echo "error";
        }
    }
}
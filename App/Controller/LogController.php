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

            if (empty($_POST['firstname'])) {
                echo " You didn't put your username !" . "<br>";
            }

            if (empty($_POST['lastname'])) {
                echo " You didn't put your lastname !" . "<br>";
            }

            if (empty($_POST['email'])) {
                echo " You didn't put your email !" . "<br>";
            }

            if (empty($_POST['password'])) {
                echo " You didn't put your password !" . "<br>";
            }

            if ($user)
            {
                $_SESSION['firstname'] = $_POST['firstname'];
                var_dump($_SESSION['firstname']);
                echo "<h1>" . "Congratulation, you are now login " . $_SESSION['firstname'] . " " . $_POST["lastname"] . "</h1>";
            } else  if (!$user) {
                echo "Your account doesn't exist";
            }
        }
    }
}
<?php


namespace App\Controller;

use Cocur\Slugify\Slugify;
use App\Model\UserModel;
use Framework\Controller;


class RegisterController extends Controller {

    public function register():void {

        $this->renderTemplate('register.html');
        $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
        $pattern2 ='/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/';
        if (isset($_POST['firstname']) && strlen($_POST['firstname'])>2 && strlen($_POST['firstname']) < 20 && isset($_POST['lastname'])&& strlen($_POST['lastname'])>2 && strlen($_POST['lastname']) < 20 && isset($_POST['email']) && preg_match($pattern2,$_POST['email']) && isset($_POST['password'])&& strlen($_POST['password'])>3&& strlen($_POST['password'])<20 && preg_match($pattern, $_POST['password'])) {

            $userModel = new UserModel();
            $user = $userModel->checkUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], password_hash($_POST['password'],PASSWORD_DEFAULT));

            if (!$user) {
                $user = $userModel->addUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], password_hash($_POST['password'],PASSWORD_DEFAULT));
                header('Location: /login');
            }
        }
    }

    public function disconnect():void{
        session_destroy();
        header('Location:/tournament/list');
    }
}
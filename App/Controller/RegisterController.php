<?php


namespace App\Controller;

use Cocur\Slugify\Slugify;
use App\Model\UserModel;
use Framework\Controller;


class RegisterController extends Controller {

    public function register() {

        $this->renderTemplate('register.html');

        if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password'])) {

            $userModel = new UserModel();
            $user = $userModel->checkUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password']);
            dump($user);

            if (!$user) {
                $user = $userModel->addUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password']);
            }

            if ($user) {
                echo "This account already exist";
            }
        }
        
    }
}
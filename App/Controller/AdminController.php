<?php


namespace App\Controller;

use Cocur\Slugify\Slugify;
use App\Model\UserModel;
use Framework\Controller;


class AdminController extends Controller{

    public function User(){
        $userModel = new UserModel();
        $user = $userModel->getUser();
        dump($user);
        dump("salut");
        $this->renderTemplate('User.html');
    }
}
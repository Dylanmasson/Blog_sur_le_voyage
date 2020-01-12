<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function homeAction(){
        return $this->render('user/pages/user.html.twig');
    }
}
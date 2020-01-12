<?php


namespace App\Controller;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;

class UserController extends AbstractController
{
    private $userRepository;
    private $articleRepository;
    private $countryRepository;

    public function __construct(UserRepository $userRepository, ArticleRepository $articleRepository, CountryRepository $countryRepository){
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
        $this->countryRepository = $countryRepository;
    }

    public function homeAction($username){

        $users = $this->userRepository->findAll();
        $user = $this->userRepository->findOneBy(["username"=>$username]);
        $articles = $this->articleRepository->findBy(["user" => $user]);
        //$country = $this->countryRepository->findOneBy(["slug" => $slug]);

        return $this->render('user/pages/user.html.twig', ["users" => $users, "user" => $user, "articles" => $articles]);
    }
}
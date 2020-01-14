<?php


namespace App\Controller;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\CountryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;

class AdminController extends AbstractController
{
    private $articleRepository;
    private $countryRepository;
    private $categoryRepository;
    private $userRepository;


    public function __construct(ArticleRepository $articleRepository, CountryRepository $countryRepository, CategoryRepository $categoryRepository, UserRepository $userRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->countryRepository = $countryRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }
    public function homeAction(){
        $username = new User;
        $user = $this->userRepository->findOneBy(["username" => $username]);
        $categories = $this->categoryRepository->findAll();
        $articles = $this->articleRepository->findBy(["user" => $user]);
        $country = $this->countryRepository->findAll();

        return $this->render('dashboard/dashboard_home.html.twig', ["user" => $user, "articles" => $articles, "categories" => $categories, "country" => $country]);
    }
}
<?php


namespace App\Controller;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    private $articleRepository;
    private $countryRepository;
    private $categoryRepository;


    public function __construct(ArticleRepository $articleRepository, CountryRepository $countryRepository, CategoryRepository $categoryRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->countryRepository = $countryRepository;
        $this->categoryRepository = $categoryRepository;
    }
    public function homeAction(){

        $categories = $this->categoryRepository->findAll();
        $articles = $this->articleRepository->findAll();
        $country = $this->countryRepository->findAll();

        return $this->render('dashboard/dashboard_home.html.twig', ["articles" => $articles, "categories" => $categories, "country" => $country]);
    }
}
<?php


namespace App\Controller;

use App\Controller\Doctrine;
use App\Repository\ArticleRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\ContinentRepository;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    private $continentRepository;
    private $articleRepository;
    private $countryRepository;

    public function __construct(ContinentRepository $continentRepository, ArticleRepository $articleRepository, CountryRepository $countryRepository)
    {
        $this->continentRepository = $continentRepository;
        $this->articleRepository = $articleRepository;
        $this->countryRepository = $countryRepository;


    } 
    
    public function homeAction($slug, Security $security){
        $continents = $this->continentRepository->findAll();
        $country = $this->countryRepository->findAll();
        $articles = $this->articleRepository->findLastFourArticles();
        $article = $this->articleRepository->findOneBy(["slug" => $slug]);
        return $this->render('home.html.twig', ["continents" => $continents, "articles"=> $articles, "article" => $article, "country" => $country]);
    }

/* 
    public function homeAction(Request $request){
 
        $continents = $this->continentRepository->findAll();
        $countries = $this->countryRepository->findBy(["continent" => $continents]);

        return $this->render('home.html.twig', ["countries" => $countries, "continents" => $continents]);

    } */


    public function article($slug)
    {
        return $this->render('pages/article.html.twig', []);
    }

    public function index(){


    }


}


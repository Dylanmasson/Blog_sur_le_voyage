<?php

namespace App\Controller;


use App\Form\SearchFormType;
use App\model\SearchModel;
use App\Repository\CountryRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SearchController extends AbstractController
{

    private $articleRepository;
    private $countryRepository;

    public function __construct(ArticleRepository $articleRepository, CountryRepository $countryRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->countryRepository = $countryRepository;
    }

    public function searchAction(Request $request)
    {
        $search = new SearchModel();
        /*$country = $this->countryRepository->findOneBy(["slug" => $slug]);
        $articles = $this->articleRepository->findBy(["country" => $country]);*/
        $searchForm = $this->createForm(SearchFormType::class);
        $articles = $this->articleRepository->findAll();

        if($searchForm->handleRequest($request)->isSubmitted() && $searchForm->isValid()){

            $search = $searchForm->getData();
            /*$articles = $this->articleRepository->searchArticle($search);*/

        }

        return $this->render('user/component/search.html.twig', [
            "articles" => $articles,
            "search" => $search,
            /*"slug" => $slug,
            "articles" => $articles,*/
            "searchForm" => $searchForm->createView(),
        ]);
    }
}

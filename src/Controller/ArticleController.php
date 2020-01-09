<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use App\Entity\Country;
use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Repository\ArticleRepository;
use App\Repository\CountryRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ArticleController extends AbstractController
{
    private $articleRepository;
    private $countryRepository;
    private $commentRepository;


    public function __construct(ArticleRepository $articleRepository, CountryRepository $countryRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->countryRepository = $countryRepository;
    }



    public function articlesAction(Request $request, $slug){
        $from = $request->query->get("from");
        

        //recuperer le country a patir du slug
        $country = $this->countryRepository->findOneBy(["slug" => $slug]);
        $articles = $this->articleRepository->findBy(["country" => $country]);

        if(is_null($from) || $from < 1) {
            $from = 1;
        }
        //Creation du formulaire
        /* public function createForm(Request $request, ObjectManager $manager){

             $comment = new Comment();
             $form = $this->createForm(CommentFormType::class, $comment);
             return $this->render('user/pages/article/{slug}',[
                "form" => $form->createView()
             ]);
        } */


        return $this->render('user/pages/country.html.twig', [
        "articles" => $articles,
        "slug" => $slug,
        ]);
    }
    public function articleAction($slug){

        $article = $this->articleRepository->findOneBy(["slug" => $slug]);
        return $this->render('user/pages/article.html.twig', [
        "article" => $article

        ]);
}


/*  public function articlesAction(Request $request, $pages){
         $from = $request->query->get("from");

      if(is_null($page) || $page < 1) {
            $page = 1;
        }

        //recuperer le country a patir du slug
        //faire une recherhe sur les articles where country = a lobjet country que tu as recuepere depuis la base de donnees
        $articles = $this->articleRepository->findPaginatedArticles([$from]);
        //$articles = $this->articleRepository->getArticlesByCountry(["country" => $country]);


        return $this->render('user/pages/country.html.twig', ["articles"=> $articles]);
    } */
}
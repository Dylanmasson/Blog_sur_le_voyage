<?php
namespace App\Controller;

use App\Model\Filter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Comment;
use Symfony\Component\Security\Core\Security;
use App\Form\CommentFormType;
use App\Form\FilterFormType;
use App\Repository\ArticleRepository;
use App\Repository\CountryRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController
{
    private $articleRepository;
    private $countryRepository;
    private $commentRepository;
    private $userRepository;
    private $categoryRepository;



    public function __construct(ArticleRepository $articleRepository, CountryRepository $countryRepository, UserRepository $userRepository, CategoryRepository $categoryRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->countryRepository = $countryRepository;
        $this->commentRepository = $countryRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }


    public function articlesAction(Request $request, $slug){
        //recuperer le country a patir du slug
        $country = $this->countryRepository->findOneBy(["slug" => $slug]);
        $articles = $this->articleRepository->findBy(["country" => $country]);
        $countries = $this->countryRepository->FindAll();

        $filter = new Filter();
        $filterForm = $this->createForm(FilterFormType::class, $filter);
        $filterForm->handleRequest($request);

        if($filterForm->isSubmitted()) {
            $filter = $filterForm->getData();
            $filter->setCountry($country);
            $articles = $this->articleRepository->filteredArticles($filter);
        }

        return $this->render('user/pages/country.html.twig', [
            "articles" => $articles,
            "slug" => $slug,
            "filter" => $filter,
            "filterForm" => $filterForm->createView(),
            "countries" => $countries

        ]);
    }


    public function articleAction($slug, Request $request, Security $security){
        $comment = new Comment();
        $article = $this->articleRepository->findOneBy(["slug" => $slug]);


        $formComment = $this->createForm(CommentFormType::class, $comment);
        $formComment->handleRequest($request);

        if($formComment->isSubmitted() && $formComment->isValid()){

            $comment = $formComment->getData();
            $user = $this->userRepository->findOneBy(['id' => $security->getUser()->getId()]);
            $comment->setUser($user)
                    ->setCreatedAt(new \DateTime())
                    ->setIsSignaled(false)
                    ->setIsVisible(true)
                    ->setArticle($article);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();

            /* return $this->render('user/pages/article.html.twig', [
                        "article" => $article, "comment" => $comment
                    ]); */
        }
        return $this->render('user/pages/article.html.twig', [
            "article" => $article,
            "comment" => $comment,
            "formComment" => $formComment->createView(),
        ]);
    }
}
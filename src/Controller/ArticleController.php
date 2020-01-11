<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Comment;
use Symfony\Component\Security\Core\Security;
use App\Form\CommentFormType;
use App\Repository\ArticleRepository;
use App\Repository\CountryRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;


class ArticleController extends AbstractController
{
    private $articleRepository;
    private $countryRepository;
    private $commentRepository;
    private $userRepository;


    public function __construct(ArticleRepository $articleRepository, CountryRepository $countryRepository, CommentRepository $commentRepository, UserRepository $userRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->countryRepository = $countryRepository;
        $this->commentRepository = $countryRepository;
        $this->userRepository = $userRepository;
    }



    public function articlesAction(Request $request, $slug){
        $from = $request->query->get("from");


        //recuperer le country a patir du slug
        $country = $this->countryRepository->findOneBy(["slug" => $slug]);
        $articles = $this->articleRepository->findBy(["country" => $country]);

        if(is_null($from) || $from < 1) {
            $from = 1;
        }


        return $this->render('user/pages/country.html.twig', [
            "articles" => $articles,
            "slug" => $slug,
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


            /* $article = $this->articleRepository->findOneBy(['id' = $id]); */


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
            "formComment" => $formComment->createView()
        ]);
    }
}
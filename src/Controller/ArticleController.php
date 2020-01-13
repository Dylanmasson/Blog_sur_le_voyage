<?php
namespace App\Controller;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use App\Entity\Country;
use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Category;
use Symfony\Component\Security\Core\Security;
use App\Form\CommentFormType;
use App\Repository\ArticleRepository;
use App\Repository\CountryRepository;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Doctrine\Common\Persistence\ObjectManager;
class ArticleController extends AbstractController
{
    private $articleRepository;
    private $countryRepository;
    private $commentRepository;
    private $userRepository;
    private $categoryRepository;

    public function __construct(ArticleRepository $articleRepository, CountryRepository $countryRepository, CommentRepository $commentRepository, UserRepository $userRepository, CategoryRepository $categoryRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->countryRepository = $countryRepository;
        $this->commentRepository = $countryRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function articlesAction($slug){

        //recuperer le country a patir du slug
        $country = $this->countryRepository->findOneBy(["slug" => $slug]);
        $articles = $this->articleRepository->findBy(["country" => $country]);
        $categories = $this->categoryRepository->findAll();
        $art = $this->articleRepository->findAll(["articles" => $articles, "categories" => $categories]);
        //$category = $this->categoryRepository->findOneById($id);


        return $this->render('user/pages/country.html.twig', [
            "articles" => $articles,
            "slug" => $slug,
            "categories" => $categories,
            "country" => $country,
            "art" => $art
        ]);
    }


    public function articleAction($slug, Request $request, Security $security){
        $article = $this->articleRepository->findOneBy(["slug" => $slug]);

        $comment = new Comment();
        $formComment = $this->createForm(CommentFormType::class, $comment);
        $formComment->handleRequest($request);

        if($formComment->isSubmitted() && $formComment->isValid()){

            $comment = $formComment->getData();
            $user = $this->userRepository->findOneBy(['username' => $security->getUser()->getUsername()]);
            $comment->setUser($user);
            $comment->getId();
            /* $article = $this->articleRepository->findOneBy(['id' = $id]); */
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('article');
        }
        return $this->render('user/pages/article.html.twig', [
            "article" => $article, "comment" => $comment,  "formComment" => $formComment->createView()
        ]);
    }

}
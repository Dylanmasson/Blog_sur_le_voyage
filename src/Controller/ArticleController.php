<?php
namespace App\Controller;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use App\Entity\Country;
use App\Entity\Comment;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use App\Form\CommentFormType;
use App\Repository\ArticleRepository;
use App\Repository\CountryRepository;
use App\Repository\CommentRepository;
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
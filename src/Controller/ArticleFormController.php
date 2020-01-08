<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;


class ArticleFormController extends AbstractController
{

    private $userRepository;
    private $articleRepository;

    public function __construct(UserRepository $userRepository, ArticleRepository $articleRepository)
    {
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
    }

    public function form(Request $request, EntityManagerInterface $manager, Security $security)
    {
        $article = new Article();
        $formArticle = $this->createForm(ArticleFormType::class, $article);

        $formArticle->handleRequest($request);

        if ($formArticle->isSubmitted() && $formArticle->isValid()){
            $actualTitle = $article->getTitle();
            $slug = strtolower(str_replace(" ", "-", $actualTitle));
            $article->setSlug($slug);
            if (!$article->getId()){
                $article->setCreatedAt(new \DateTime());
            }
            $user = $this->userRepository->findOneBy(['email' => $security->getUser()->getEmail()]);
            $article->setUser($user);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('articles', ['id' => $article->getId()]);
        }
        return $this->render('dashboard/form/article_form.html.twig', [
            'formArticle' => $formArticle->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }


}

<?php


namespace App\Controller;

use App\Controller\Doctrine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\ContinentRepository;
use App\Repository\CountryRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    private $continentRepository;
    private $userRepository;

    public function __construct(ContinentRepository $continentRepository, UserRepository $userRepository)
    {
        $this->continentRepository = $continentRepository;
        $this->userRepository = $userRepository;
    } 
    
    public function homeAction(Security $security){
        $continents = $this->continentRepository->findAll();
        $user = $this->userRepository->findOneBy(['id' => $security->getUser()->getId()]);
        return $this->render('home.html.twig', ["continents" => $continents, "user" => $user]);
    }

/* 
    public function homeAction(Request $request){
 
        $continents = $this->continentRepository->findAll();
        $countries = $this->countryRepository->findBy(["continent" => $continents]);

        return $this->render('home.html.twig', ["countries" => $countries, "continents" => $continents]);

    } */


}
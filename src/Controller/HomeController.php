<?php


namespace App\Controller;

use App\Controller\Doctrine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\ContinentRepository;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    private $continentRepository;

    public function __construct(ContinentRepository $continentRepository)
    {
        $this->continentRepository = $continentRepository;

    } 
    
    public function homeAction(Security $security){
        $continents = $this->continentRepository->findAll();
        return $this->render('home.html.twig', ["continents" => $continents]);
    }

/* 
    public function homeAction(Request $request){
 
        $continents = $this->continentRepository->findAll();
        $countries = $this->countryRepository->findBy(["continent" => $continents]);

        return $this->render('home.html.twig', ["countries" => $countries, "continents" => $continents]);

    } */


}
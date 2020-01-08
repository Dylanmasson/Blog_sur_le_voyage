<?php


namespace App\Controller;

use App\Controller\Doctrine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use App\Repository\ContinentRepository;
use App\Repository\CountryRepository;
use Symfony\Component\HttpFoundation\Request;

class NavbarController extends AbstractController
{

    private $continentRepository;
    private $countryRepository;


    public function __construct(ContinentRepository $continentRepository, CountryRepository $countryRepository)
    {
        $this->continentRepository = $continentRepository;
        $this->countryRepository = $countryRepository;
    }
    

    public function homeAction(Request $request){
 
        $continents = $this->continentRepository->findAll();
        $countries = $this->countryRepository->findBy(["continent" => $continents]);
        //$countries = $this->countryRepository->findAll();
        return $this->render('user/component/navbar.html.twig', ["countries" => $countries, "continents" => $continents]);

    }


}
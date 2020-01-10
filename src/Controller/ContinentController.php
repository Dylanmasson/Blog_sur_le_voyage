<?php

namespace App\Controller;

use App\Repository\ContinentRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContinentController extends AbstractController
{

    private $continentRepository;
    private $countryRepository;

    public function __construct(ContinentRepository $continentRepository, CountryRepository $countryRepository)
    {
        $this->continentRepository = $continentRepository;
        $this->countryRepository = $countryRepository;
    }

// Rajout du slug plus tard
    public function continentAction($name){
        $continent = $this->continentRepository->findOneBy(["name" => $name]);
        $countries = $this->countryRepository->findBy(["continent" => $continent]);

        return $this->render('user/pages/continent.html.twig', ["countries" => $countries, "name" => $name]);
    }



}

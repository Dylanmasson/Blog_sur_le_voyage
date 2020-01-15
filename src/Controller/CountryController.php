<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Country;
use App\Repository\CountryRepository;
use App\Repository\ArticleRepository;


class CountryController extends AbstractController
{
    private $countryRepository;


    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function countryAction(){

        $country = $this->countryRepository->FindAll();


        return $this->render('user/pages/country.html.twig', ["country" => $country]);
    }

}
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

}
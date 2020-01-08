<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContinentController extends AbstractController
{
    /**
     * @Route("/continent", name="continent")
     */
    public function index()
    {
        return $this->render('');
    }
}

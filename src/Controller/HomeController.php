<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $title = "Hello WCS !";
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'title' => $title
        ]);
    }
}

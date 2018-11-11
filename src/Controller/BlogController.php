<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/index", name="blog")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/blog/{slug}", requirements={"slug"="[a-z0-9\-]*"}, name="blog_show")
     */
    public function show($slug){
        if ($slug){
            $title = ucwords(str_replace('-', ' ', $slug));
        }else{
            $title = 'Article Sans Titre';
        }
        return $this->render('blog/show.html.twig', ['title' => $title]);
    }
}

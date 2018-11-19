<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }


    /**
     * @Route("/article/{id}", name="article_show")
     *
     */
    public function show(Article $article) :Response
    {
        return $this->render('article/show.html.twig', ['article'=>$article]);
    }

    /**
     *@Route("/articles", name="article_list")
     */

    public function list()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render('article/category.html.twig', ['articles' => $articles]);
    }

}

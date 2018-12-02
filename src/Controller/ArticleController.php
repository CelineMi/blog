<?php

namespace App\Controller;

use App\Entity\Article;
// use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;


class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="article")
     */
    public function index()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/add", name="add_article")
     */
    public function add(Request $request) : Response
    {
        $articles = new Article();
        $form = $this->createForm(ArticleType::class, $articles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            return $this->redirectToRoute('add_article');
            // $data contient les données du $_POST
            // Faire une recherche dans la BDD avec les infos de $data...
        }

        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('article/add.html.twig', [
            'form' => $form->createView(),
            'articles' => $articles,
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

        return $this->render('article/index.html.twig', ['articles' => $articles]);
    }

    /**
     *@Route("/blog/tag/{name}", name="show_tag_by_name")
     */
    /*public function tag(Tag $tag) : Response
    {
        $tags = $tag->getArticles();

        return $this->render('article/tag.html.twig', ['tags' => $tags]);
    }*/


}

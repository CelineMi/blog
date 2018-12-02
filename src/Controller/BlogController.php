<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CategoryType;
use App\Entity\Article;
use App\Form\ArticleSearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class BlogController extends AbstractController
{
    /**
     * Show all row from article's entity
     *
     * @Route("/", name="blog_index")
     * @return Response A response instance
     */
    public function index(Request $request) : Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }
        $defaultData = array('searchField' => 'Type your research here');
        $form = $this->createFormBuilder($defaultData)
            ->add('searchField', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $searchField = $data['searchField'];
            $res = $this->getDoctrine()->getRepository(Article::class)->createQueryBuilder('a')
                ->where('a.title LIKE :searchTerm')->setParameter('searchTerm', '%'. $searchField .'%' )
                ->getQuery()->getResult();
            $articles = $res;
            // $data contient les données du $_POST
            // Faire une recherche dans la BDD avec les infos de $data...

        }


        return $this->render(
            'blog/index.html.twig', [
                'articles' => $articles,
                'form' => $form->createView(),
            ]
        );

    }

    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/article/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     *  @return Response A response instance
     */
    public function show($slug) : Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$slug.' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }


    /**
     * @Route("/Category/{Category}", name="blog_show_category")
     * @return Response A response instance
     */
    public function showByCategory(string $category) : Response
    {
        $category = $this
            ->getDoctrine()
            ->getRepository(Category::class)
            ->findOneByName($category);

        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(array ('exCategory'=> $category),  array ('id' =>'ASC'), 3);


        return $this->render
            ('blog/exCategory.html.twig',
            [
                'articles' => $articles,
                'exCategory'=> $category
            ]

        );
    }

    /**
     * @Route("/Category/{name}/all", name="blog_show_all_category")
     * @return Response A response instance
     *
     */
    public function showAllByCategory(Category $category) : Response
    {
        $categories = $category->getArticles();


        return $this->render
        ('blog/showAllByCategory.html.twig',
            [
                'categories'=> $categories
            ]

        );
    }
}

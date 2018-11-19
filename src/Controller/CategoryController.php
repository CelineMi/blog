<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CategoryRepository;
use App\Form\ArticleSearchType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategoryType;


class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(Request $request) : Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            return $this->redirectToRoute('category');
            // $data contient les données du $_POST
            // Faire une recherche dans la BDD avec les infos de $data...
        }
            return $this->render(
                'category/index.html.twig', [
                'form' => $form->createView(),
                'categories' => $categories,
            ]);

    }

    /**
     * @Route("/category/{id}", name="category_show")
     *
     */
    public function show(Category $category) :Response
    {
        return $this->render('category/show.html.twig', ['category'=>$category]);
    }
}

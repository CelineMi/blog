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


class EXCategoryController extends AbstractController
{
    /**
     * @Route("/exCategory", name="exCategory")
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
            return $this->redirectToRoute('exCategory');
            // $data contient les données du $_POST
            // Faire une recherche dans la BDD avec les infos de $data...
        }
            return $this->render(
                'exCategory/index.html.twig', [
                'form' => $form->createView(),
                'categories' => $categories,
            ]);

    }

    /**
     * @Route("/exCategory/{id}", name="old_category_show")
     *
     */
    public function show(Category $category) :Response
    {
        return $this->render('exCategory/show.html.twig', ['exCategory'=>$category]);
    }
}

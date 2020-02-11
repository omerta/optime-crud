<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Form\CategoryType;

class CategoryController extends AbstractController
{
 
    /**
     * @Route("/category/create", name="category_create")
     */
    public function create(Request $request)
    {
        $category = new Category;
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category');
            // return $this->redirectToRoute('category_show', $category->getId());
        }

        return $this->render('category/edit.html.twig', [
            'action' => 'Nueva',
            'form' => $form->createView()
        ]);
    }
 
    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        $categories = $this->getDoctrine()
           ->getRepository(Category::class)
           ->findAll();

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController::index',
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function show($id)
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);

        return $this->render('category/show.html.twig', [
            'controller_name' => 'CategoryController::show',
            'category' => $category
        ]);   
    }

    /**
     * @Route("/category/edit/{id}", name="category_edit")
     */
    public function edit(Request $request, int $id)
    {
        // https://symfony.com/doc/current/doctrine.html#updating-an-object
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository(Category::class)
            ->find($id);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            

            $category = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('category');
            // return $this->redirectToRoute('category_show', $category->getId());
        }

        return $this->render('category/edit.html.twig', [
            'action' => 'Editar',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="category_delete")
     */
    public function delete(int $id)
    {
        
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository(Category::class)
            ->find($id);

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('category');
    }

    /**
     * @Route("/category/statusUpdate/{id}", name="category_status_update")
     */
    public function changeStatus(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository(Category::class)
            ->find($id);

        $category->setStatus(!$category->getStatus());
        $entityManager->flush();

        return $this->json(['status' => 'success']);
    }
}

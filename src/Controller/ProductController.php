<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Form\ProductType;
use App\Repository\ProductRepository;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/create", name="product_create")
     */
    public function create(Request $request)
    {
        $product = new Product;
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product');
            // return $this->redirectToRoute('product_show', $category->getId());
        }

        return $this->render('product/edit.html.twig', [
            'controller_name' => 'ProductController::create',
            'form' => $form->createView()
        ]);
    }
 

    /**
     * @Route("/product", name="product")
     */
    public function index(Request $request)
    {
        // $products = $this->getDoctrine()
        //     ->getRepository(Product::class)
        //     ->findAll();

        if ($request->query->getAlnum('filter')) {
            $products = $this->getDoctrine()
                ->getRepository(Product::class)
                ->filterByName($request->query->getAlnum('filter'));
        } else {
            $products = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findOneByIdJoinedToCategory();
        }

        
        // $products = $products->getCategory();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);
    }

    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function show($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        return $this->render('product/show.html.twig', [
            'controller_name' => 'ProductController::show',
            'product' => $product
        ]);   
    }

    /**
     * @Route("/product/edit/{id}", name="product_edit")
     */
    public function edit(Request $request, int $id)
    {
        // https://symfony.com/doc/current/doctrine.html#updating-an-object
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)
            ->find($id);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $product = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('product');
            // return $this->redirectToRoute('category_show', $category->getId());
        }

        return $this->render('product/edit.html.twig', [
            'controller_name' => 'productController::edit',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete")
     */
    public function delete(int $id)
    {
        
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)
            ->find($id);

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('product');
    }
}

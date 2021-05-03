<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
class FrontController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index(): Response
    {
        return $this->render('front/index.html.twig');
    }
    //get main categories
    public function mainCategories(){
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findBy(['parent'=>null], ['name'=>'ASC'])
        ;
        return $this->render('front/main_categories.html.twig',[
            'categories'=>$categories
        ]);
    }
}


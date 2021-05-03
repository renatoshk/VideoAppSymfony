<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Utils\CategoryAdminOptionList;
use App\Utils\CategoryAdminTree;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin")
 */
class AdminCategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories", methods={"GET", "POST"})
     */
    public function index(CategoryAdminTree $categoryAdminTree, Request $request)
    {
        $isInValid = null;
        $categoryAdminTree->getCategoryList($categoryAdminTree->buildTree());
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        if($this->saveCategory($category, $form, $request)){
           return $this->redirectToRoute('categories');
        }elseif($request->isMethod('post')){
            $isInValid = 'is-invalid';
        }
        return $this->render('admin/categories.html.twig', [
            'categories'=>$categoryAdminTree->treeCategoryHtml,
            'form'=>$form->createView(),
            'is_invalid'=>$isInValid
        ]);
    }
    /**
     * @Route("/edit-category/{id}", name="edit_category", methods={"GET", "POST"})
     */
    public function editCategory(Category $category, Request $request)
    {
        $isInValid = null;
        $form = $this->createForm(CategoryType::class, $category);
        if($this->saveCategory($category, $form, $request)){
            return $this->redirectToRoute('categories');
        }elseif($request->isMethod('post')){
            $isInValid = 'is-invalid';
        }
        return $this->render('admin/edit_category.html.twig',[
            'category'=>$category,
            'form'=>$form->createView(),
            'is_invalid'=>$isInValid
        ]);
    }
    /**
     * @Route("/delete-category/{id}", name="delete_category")
     */
    public function deleteCategory(Category $category)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        return $this->redirectToRoute('categories');
    }
    public function getAllCategories(CategoryAdminOptionList $category, $editedCategory = null){
        $category->getCategoryList($category->buildTree());
        return $this->render('admin/option_categories.html.twig', [
            'categories'=>$category,
            'editedCategory'=>$editedCategory
        ]);
    }
    private function saveCategory($category, $form, $request){
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $category->setName($request->request->get('category')['name']);
            $repository = $this->getDoctrine()->getRepository(Category::class);
            $parentCat = $repository->find($request->request->get('category')['parent']);
            $category->setParent($parentCat);
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return true;
        }
        return false;
    }
}

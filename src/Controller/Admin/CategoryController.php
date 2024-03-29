<?php

namespace App\Controller\Admin;

use App\DTO\SearchCategoryCriteria;
use App\Entity\Category;
use App\Form\AdminCategoryFormType;
use App\Form\SearchCategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/admin/categories")]
class CategoryController extends AbstractController
{
    #[Route('/nouvelle', name: 'app_category_createCategory')]
    public function createCategory(Request $request, CategoryRepository $repository): Response
    {
        $form = $this->createForm(AdminCategoryFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $repository->add($category, true);

            return $this->redirectToRoute("app_category_list");
        }

        return $this->render("admin/category/createCategory.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route("/liste", name: "app_category_list")]
    public function list(Request $request, CategoryRepository $repository): Response
    {
        // $categories = $repository->findAll();

        $criteria = new SearchCategoryCriteria();

        $form = $this->createForm(SearchCategoryType::class, $criteria);

        $form->handleRequest($request);

        $categories = $repository->findByCriteria($criteria);

        return $this->render(
            "admin/category/list.html.twig",
            [
                "categories" => $categories,
                "form" => $form->createView()
            ]
        );
    }

    #[Route("/modifier/{id}", name: "app_category_updateCategory")]
    public function updateCategory(Request $request, CategoryRepository $repository, int $id): Response
    {
        $category = $repository->find($id);

        $form = $this->createForm(AdminCategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();

            $repository->add($category, true);

            return $this->redirectToRoute("app_category_list");
        }

        return $this->render("admin/category/updateCategory.html.twig", [
            "form" => $form->createView(),
            "category" => $category
        ]);

        // $category = $repository->find($id);

        // if ($request->isMethod("POST")) {
        //     $name = $request->request->get("name");

        //     $category->getName($name);

        //     $repository->add($category, true);

        //     return $this->redirectToRoute("app_category_list");
        // }

        // return $this->render(
        //     "category/updateCategory.html.twig",
        //     [
        //         "category" => $category,
        //         "id" => $id
        //     ]
        // );
    }

    #[Route("/supprimer/{id}", name: "app_category_deleteCategory")]
    public function deleteCategory(CategoryRepository $repository, int $id): Response
    {
        $category = $repository->find($id);

        $repository->remove($category, true);

        return $this->redirectToRoute("app_category_list");
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repository\CategoryRepository;

class CategoryController extends AbstractController
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * @Route("/category", name="add_category", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];

        if (empty($name)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->categoryRepository->saveCategory($name);

        return new JsonResponse(['status' => 'Category created!'], Response::HTTP_CREATED);
    }


    /**
     * @Route("/categories", name="get_all_categories", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $categories = $this->categoryRepository->findAll();
        $data = [];

        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->getId(),
                'categoryName' => $category->getName()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
    * @Route("/category/{id}", name="get_one_category", methods={"GET"})
    */
    public function getCategoryById($id): JsonResponse
    {
        $category = $this->categoryRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $category->getId(),
            'name' => $category->getName(),
        ];
    
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
    * @Route("/category/{id}", name="update_category", methods={"PUT"})
    */
    public function update($id, Request $request): JsonResponse
    {
        $category = $this->categoryRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $category->setName($data['name']);

        $updatedCategory = $this->categoryRepository->updateCategory($category);

        return new JsonResponse($updatedCategory->toArray(), Response::HTTP_OK);
    }


    /**
     * @Route("/category/{id}", name="delete_category", methods={"DELETE"}): JsonResponse
     */
    public function deleteCategory($id)
    {
        $category = $this->categoryRepository->findOneBy(['id' => $id]);
        $categories = $this->categoryRepository->deleteCategory($category);
        
        return new JsonResponse(['status' => 'Category deleted'], Response::HTTP_NO_CONTENT);
    }
}

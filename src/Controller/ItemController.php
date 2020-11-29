<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ItemRepository;
use App\Repository\CategoryRepository;

use App\Entity\Category;

class ItemController extends AbstractController
{

    private $itemRepository;
    private $categoryRepository;

    public function __construct(ItemRepository $itemRepository, CategoryRepository $categoryRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/item", name="item")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ItemController.php',
        ]);
    }

    /**
     * @Route("/items", name="get_items", methods={"GET"}): JsonResponse
     */
    public function getAllItems(): JsonResponse
    {
        $categories = $this->categoryRepository->findAll();
        $categoriesData = [];

        foreach ($categories as $category) {
            $items = $category->getItems();
            $itemsData = [];

            foreach ($items as $item) {
                $itemsData[] = [
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                ];
            }

            $categoriesData[] = [
                'id' => $category->getId(),
                'categoryName' => $category->getName(),
                'items' => $itemsData,
            ];
        }
    
        return new JsonResponse($categoriesData, Response::HTTP_OK);
    }

    /**
     * @Route("/items/add", name="add_item", methods={"POST"}): JsonResponse
     */
    public function addItem(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $category_id = $data['categoryId'];

        if (empty($name) || empty($category_id)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $category = $this->categoryRepository->find($category_id);

        $this->itemRepository->saveItem($name, $category);

        return new JsonResponse(['status' => 'Item created!', 'data' => []], Response::HTTP_CREATED);
    }
}

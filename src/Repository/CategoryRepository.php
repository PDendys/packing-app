<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Category::class);
        $this->manager = $manager;
    }

    public function saveCategory($name)
    {
        $newCategory = new Category();

        $newCategory
            ->setName($name);

        $this->manager->persist($newCategory);
        $this->manager->flush();
    }

    public function updateCategory(Category $category): Category
    {
        $this->manager->persist($category);
        $this->manager->flush();

        return $category;
    }

    public function deleteCategory(Category $category)
    {
        $this->manager->remove($category);
        $this->manager->flush();
    }
}

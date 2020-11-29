<?php

namespace App\Repository;

use App\Entity\Trip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Trip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trip[]    findAll()
 * @method Trip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Trip::class);
        $this->manager = $manager;
    }

    // /**
    //  * @return Trip[] Returns an array of Trip objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trip
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function saveTrip($name, $destenation, $fellowPassenger, $tripStartDate, $tripEndDate, $isPackingFinished = false)
    {
        $newTrip = new Trip();

        $newTrip
            ->setName($name)
            ->setDestenation($destenation)
            ->setFellowPassenger($fellowPassenger)
            ->setTripStartDate(
                \DateTime::createFromFormat('Y-m-d', $tripStartDate)
            )
            ->setTripEndDate(
                \DateTime::createFromFormat('Y-m-d', $tripEndDate)
            )
            ->setIsPackingFinished($isPackingFinished);

        $this->manager->persist($newTrip);
        $this->manager->flush();

        return $newTrip->transformToArray();
    }

    public function updateTrip($id, $name = '', $destenation = '', $fellowPassenger = '', $isPackingFinished = null)
    {
        $trip = $this->find($id);

        if (!empty($name))
        {
            $trip->setName($name);
        }

        if (!empty($destenation))
        {
            $trip->setName($destenation);
        }

        if (!empty($fellowPassenger))
        {
            $trip->setFellowPassenger($fellowPassenger);
        }

        if (!is_null($isPackingFinished))
        {
            $trip->setIsPackingFinished($isPackingFinished);
        }

        $this->manager->persist($trip);
        $this->manager->flush();
    }
}

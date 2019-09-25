<?php

namespace App\Repository;

use App\Entity\QueueTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method QueueTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method QueueTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method QueueTask[]    findAll()
 * @method QueueTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QueueTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QueueTask::class);
    }

    // /**
    //  * @return QueueTask[] Returns an array of QueueTask objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QueueTask
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
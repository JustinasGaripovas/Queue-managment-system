<?php

namespace App\Repository;

use App\Entity\QueueTaskStatusLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method QueueTaskStatusLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method QueueTaskStatusLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method QueueTaskStatusLog[]    findAll()
 * @method QueueTaskStatusLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QueueTaskStatusLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QueueTaskStatusLog::class);
    }

    // /**
    //  * @return QueueTaskStatusLog[] Returns an array of QueueTaskStatusLog objects
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
    public function findOneBySomeField($value): ?QueueTaskStatusLog
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

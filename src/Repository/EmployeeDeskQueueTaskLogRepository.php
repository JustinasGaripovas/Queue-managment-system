<?php

namespace App\Repository;

use App\Entity\EmployeeDeskQueueTaskLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EmployeeDeskQueueTaskLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeDeskQueueTaskLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeDeskQueueTaskLog[]    findAll()
 * @method EmployeeDeskQueueTaskLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeDeskQueueTaskLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeDeskQueueTaskLog::class);
    }

    // /**
    //  * @return EmployeeDeskQueueTaskLog[] Returns an array of EmployeeDeskQueueTaskLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EmployeeDeskQueueTaskLog
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\EmployeeDesk;
use App\Entity\QueueTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException as NonUniqueResultExceptionAlias;

/**
 * @method EmployeeDesk|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeDesk|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeDesk[]    findAll()
 * @method EmployeeDesk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeDeskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeDesk::class);
    }

    /**
     * @param QueueTask $queueTask
     * @return mixed
     */
    public function findCorrectDeskForQueueTask(QueueTask $queueTask)
    {
        return $this->createQueryBuilder('d')
            ->setParameter('interestType', $queueTask->getInterestType()->getId())
            ->innerJoin('d.employee', 'e', 'd.employee = e.id')
            ->innerJoin('e.interestType', 'it', 'e.interestType = it.id')
            ->andWhere('it.id = :interestType')
            ->andWhere('d.isOnline = true')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return array
     */
    public function findOnlineTables(){

        return $this->createQueryBuilder('d')
            ->andWhere('d.isOnline = true')
            ->getQuery()
            ->getResult();
    }

}

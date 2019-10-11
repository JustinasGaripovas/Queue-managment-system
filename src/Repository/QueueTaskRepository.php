<?php

namespace App\Repository;

use App\Entity\QueueTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

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


    /**
     * @param $interestType
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function findOldestIdToday($interestType)
    {
        return $this->createQueryBuilder('qt')
            ->innerJoin('qt.interestType', 'i', 'i.id = qt.interestType')
            ->andWhere('i.id = :interestType')
            ->setParameter('interestType', $interestType)
            ->andWhere('qt.createdAt > UNIX_TIMESTAMP(CURRENT_DATE())')
            ->orderBy('qt.queueNumber','desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param $interestType
     * @return QueueTask|null
     * @throws NonUniqueResultException
     */
    public function findNextAvailable($interestType):? QueueTask
    {
        //-  Reikia rasti maziausia
        //-  Skaiciu kuriu nera aktyviu

        $query = $this->createQueryBuilder('qt')
            ->andWhere('qt.isQueueNumberInUse = false')
            ->andWhere('qt.createdAt > UNIX_TIMESTAMP(CURRENT_DATE())')
            ->innerJoin('qt.interestType', 'i', 'i.id = qt.interestType')
            ->andWhere('i.id = :interestType')
            ->setParameter('interestType', $interestType)
            ->orderBy('qt.queueNumber','asc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if ($query === null)
            return null;

        $updateQuery = $this->createQueryBuilder('q')
            ->update('App:QueueTask', 'uq')
            ->andWhere('uq.queueNumber = :queueNumber')
            ->setParameter('queueNumber', $query->getQueueNumber())
            ->andWhere('uq.createdAt > UNIX_TIMESTAMP(CURRENT_DATE())')
            ->andWhere('uq.interestType = :interestType')
            ->setParameter('interestType', $interestType)
            ->set('uq.isQueueNumberInUse', 1)
            ->set('uq.isActive', 0)
        ;

        $updateQuery->getQuery()->execute();

        /*Danger*/

        return $query;
    }

}

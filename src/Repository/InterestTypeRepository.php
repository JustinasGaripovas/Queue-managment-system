<?php

namespace App\Repository;

use App\Entity\InterestType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method InterestType|null find($id, $lockMode = null, $lockVersion = null)
 * @method InterestType|null findOneBy(array $criteria, array $orderBy = null)
 * @method InterestType[]    findAll()
 * @method InterestType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterestTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InterestType::class);
    }

    /**
     * @return InterestType[] Returns an array of InterestType objects
     */
    public function findAllRoots()
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.interestType is NULL')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $id
     * @return InterestType
     * @throws NonUniqueResultException
     */
    public function findOneById($id): InterestType
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

}

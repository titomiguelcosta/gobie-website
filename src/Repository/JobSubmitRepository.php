<?php

namespace App\Repository;

use App\Entity\JobSubmit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method JobSubmit|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobSubmit|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobSubmit[]    findAll()
 * @method JobSubmit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobSubmitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobSubmit::class);
    }

    // /**
    //  * @return JobSubmit[] Returns an array of JobSubmit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JobSubmit
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

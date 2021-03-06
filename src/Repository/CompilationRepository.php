<?php

namespace App\Repository;

use App\Entity\Compilation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Compilation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Compilation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Compilation[]    findAll()
 * @method Compilation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompilationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Compilation::class);
    }

    /*
     * findAll where creator isn't actual user
     */
    public function findOther($user): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.creator != :user')
            ->andWhere('c.private = false')
            ->setParameter('user', $user )
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }
}

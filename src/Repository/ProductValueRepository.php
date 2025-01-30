<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductValue::class);
    }

    public function findByImportHash(string $importHash): ?ProductValue
    {
        $qb = $this->createQueryBuilder('pv');

        $qb->where('pv.importHash = :importHash')
            ->setParameter('importHash', $importHash)
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function save(ProductValue $productValue): ProductValue
    {
        $this->getEntityManager()->persist($productValue);
        $this->getEntityManager()->flush();
    }
}

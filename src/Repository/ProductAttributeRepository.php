<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductAttributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductAttribute::class);
    }

    public function findOneByImportHash(string $importHash): ?ProductAttribute
    {
        $qb = $this->createQueryBuilder('pa');

        $qb->where('pa.importHash = :importHash')
            ->setParameter('importHash', $importHash)
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findOneByImportId(int $importId): ?ProductAttribute
    {
        $qb = $this->createQueryBuilder('pa');

        $qb->where('pa.importId = :importId')
            ->setParameter('importId', $importId)
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findOneById(int $id): ?ProductAttribute
    {
        $qb = $this->createQueryBuilder('pa');

        $qb->where('pa.id = :id')
            ->setParameter('id', $id)
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function save(ProductAttribute $productAttribute): ProductAttribute
    {
        $this->getEntityManager()->persist($productAttribute);
        $this->getEntityManager()->flush();
    }
}

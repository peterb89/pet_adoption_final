<?php
 
namespace App\Repository\Animals;
 
use App\Entity\Animals\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
 
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }
 
    public function findByFilters(
        ?string $search = null,
        ?int $speciesId = null,
        ?string $size = null,
        ?string $gender = null,
    ): array {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.species', 's')
            ->addSelect('s');
 
        if ($search) {
            $qb->andWhere('a.name LIKE :search OR a.breed LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }
 
        if ($speciesId) {
            $qb->andWhere('s.id = :speciesId')
               ->setParameter('speciesId', $speciesId);
        }
 
        if ($size) {
            $qb->andWhere('a.size = :size')
               ->setParameter('size', $size);
        }
 
        if ($gender) {
            $qb->andWhere('a.gender = :gender')
               ->setParameter('gender', $gender);
        }
 
        return $qb->orderBy('a.name', 'ASC')
                  ->getQuery()
                  ->getResult();
    }
}
 
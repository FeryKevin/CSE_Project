<?php

namespace App\Repository;

use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offer>
 *
 * @method Offer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offer[]    findAll()
 * @method Offer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    public function save(Offer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Offer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Return some offer with asked page
     * 
     * @param int $page the page number
     * @param int $limit the number per page
     * 
     * @return Offer[]
     */
    public function findWithPaginator(int $page, int $limit, string $type = null): array
    {
        $result = [];
        $page = abs($page);

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('f')
            ->from('App\Entity\Offer', 'f')
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit)
            ->addOrderBy('f.limitedDisplayNumber', 'ASC')
            ->addOrderBy('f.publishedAt', 'DESC');
        if ($type === "limited") {
            $query
                ->where('f.permanentValidityBeginning IS null')
                ->andWhere($query->expr()->neq('f.limitedDisplayNumber', 0));
        } elseif ($type === "permanent") {
            $query
                ->where('f.limitedDisplayNumber IS null');
        } elseif ($type === "lastLimited") {
            $query
                ->where('f.permanentValidityBeginning IS null')
                ->andWhere($query->expr()->neq('f.limitedDisplayNumber', 0))
                ->orderBy('f.publishedAt', 'DESC');
        }

        $paginator = new Paginator($query);
        $data = $query->getQuery()->getResult();

        if (empty($data)) return $result;

        $result['data'] = $data;
        $result['pages'] = ceil($paginator->count() / $limit);
        $result['currentPage'] = $page;
        $result['limit'] = $limit;

        return $result;
    }

    //    /**
    //     * @return Offer[] Returns an array of Offer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Offer
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

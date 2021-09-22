<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function search($name, $sort, $page)
    {
        $qb = $this->createQueryBuilder('e'); // SELECT e.id, e.name FROM event e

        if (!empty($name)) {
            $qb->where('e.name LIKE :name') // WHERE name = :name
                ->setParameter('name', '%'.$name.'%'); // bindValue()
        }

        // Pour le prix, on fait asc pour avoir le moins cher
        // Pour la date, on fait desc pour avoir la plus récente
        if ($sort === 'price') {
            $qb->orderBy('e.price', 'asc');
        } else if ($sort === 'date') {
            $qb->orderBy('e.startAt', 'desc');
        }

        // Pagination
        $itemByPage = 2;
        $qb->setFirstResult(($page - 1) * $itemByPage); // OFFSET 0
        $qb->setMaxResults($itemByPage); // LIMIT 2


        return $qb->getQuery() // PDO Statement
            ->getResult(); // fetchAll
    }

    public function countIncoming()
    {
        return $this->createQueryBuilder('e')
            ->select('count(e.id)')
            ->andWhere('e.startAt > :startAt')
            ->setParameter('startAt', new \DateTime())
            ->getQuery()
            ->getSingleScalarResult();
        // $qb->select('???')
        // select count(*) from event where startAt > now() ?
        // ->getOneOrNullResult() => fetch()
        // ->getResult() => fetchAll()
        // ->getSingleScalarResult() => ->fetchColumn()
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
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
    public function findOneBySomeField($value): ?Event
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

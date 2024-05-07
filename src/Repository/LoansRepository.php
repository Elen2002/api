<?php

namespace App\Repository;

use App\Entity\Loans;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Loans>
 */
class LoansRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Loans::class);

    }//end __construct()

    /**
     * @param array $params
     * @return array $res
     */
    public function getLoans(array $params=[])
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(
            [
                'l.id',
                'l.amount',
                'l.percent',
                'l.creationDate',
            ]
        );
        $qb->from(Loans::class, 'l');
        $qb->orderBy('l.id', 'DESC');
        if (isset($params['limit']) === true) {
            $qb->setMaxResults((int) $params['limit']);
        }

        if (isset($params['amount']) === true) {
            $qb->where('CONCAT(l.amount, \'\') LIKE :value OR CONCAT(l.creationDate, \'\') LIKE :value');
            $qb->setParameter('value', '%'.$params['amount'].'%');
        }

        if (isset($params['date']) === true) {
            $qb->where('CONCAT(l.amount, \'\') LIKE :value OR CONCAT(l.creationDate, \'\') LIKE :value');
            $qb->setParameter('value', '%'.$params['date'].'%');
        }

            $res = $qb->getQuery()->getArrayResult();

            return $res;

    }//end getLoans()

    /**
     * @param $id
     * @return mixed
     */
    public function getLoan($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(
            [
                'l.id',
                'l.amount',
                'l.percent',
                'l.creationDate',
            ]
        )->from(Loans::class, 'l')->where('l.id='.$id);
        $res = $qb->getQuery()->getSingleResult();

        return $res;

    }//end getLoan()


    // **
    // * @return Loans[] Returns an array of Loans objects
    // */
    // public function findByExampleField($value): array
    // {
    // return $this->createQueryBuilder('l')
    // ->andWhere('l.exampleField = :val')
    // ->setParameter('val', $value)
    // ->orderBy('l.id', 'ASC')
    // ->setMaxResults(10)
    // ->getQuery()
    // ->getResult()
    // ;
    // }
    // public function findOneBySomeField($value): ?Loans
    // {
    // return $this->createQueryBuilder('l')
    // ->andWhere('l.exampleField = :val')
    // ->setParameter('val', $value)
    // ->getQuery()
    // ->getOneOrNullResult()
    // ;
    // }
}//end class

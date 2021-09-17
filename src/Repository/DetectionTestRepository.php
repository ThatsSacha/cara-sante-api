<?php

namespace App\Repository;

use App\Entity\DetectionTest;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetectionTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetectionTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetectionTest[]    findAll()
 * @method DetectionTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetectionTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetectionTest::class);
    }

    // /**
    //  * @return DetectionTest[] Returns an array of DetectionTest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetectionTest
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAll() {
        $db = $this->getEntityManager()->getConnection();
        $query = 'SELECT * FROM detection_test';
        $d = $db->prepare($query);
        $d->execute();

        return $d->fetchAll();
    }

    public function create(DetectionTest $detectionTest) {
        $db = $this->getEntityManager()->getConnection();
        $query = 'INSERT INTO detection_test (patient_id, tested_at, is_invoiced) VALUES(?, ?, ?)';
        $d = $db->prepare($query);
        $d->executeQuery(array(
            $detectionTest->getPatient()->getId(),
            date_format($detectionTest->getTestedAt(), 'Y-m-d H:i'),
            $detectionTest->getIsInvoiced()
        ));
    }

    public function getStatsByUser(Users $user) {
        $db = $this->getEntityManager()->getConnection();

        $query = 'SELECT * FROM detection_test
        WHERE is_invoiced = true
        AND user_id = ' . $user->getId() . '
        ORDER BY filled_at DESC';

        $query = $db->prepare($query);
        $query->executeQuery();

        return $query->fetchAll();
    }

    public function getStats() {
        $db = $this->getEntityManager()->getConnection();

        $query = 'SELECT * FROM detection_test
        WHERE is_invoiced = true
        ORDER BY filled_at DESC';

        $query = $db->prepare($query);
        $query->executeQuery();

        return $query->fetchAll();
    }
}

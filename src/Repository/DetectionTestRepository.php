<?php

namespace App\Repository;

use App\Entity\DetectionTest;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

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
        $tmp = $d->execute();

        return $tmp->fetchAll();
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

    public function getRemaining() {
        $db = $this->getEntityManager()->getConnection();

        $query = 'SELECT count(*) AS count FROM detection_test
        WHERE filled_at IS NULL';

        $query = $db->prepare($query);
        $query->executeQuery();

        return $query->fetchAll();
    }

    public function findRandomTests() {
        $db = $this->getEntityManager()->getConnection();

        $query = 'SELECT * FROM detection_test AS d
            (
                SELECT first_name FROM patient
            )
            WHERE d.is_invoiced = :val
            ORDER BY RAND() LIMIT 20
        ';

        $query = $db->prepare($query);
        $query->executeQuery(array('val' => false));

        return array_map(function($el) {
            $el['id'] = (int) $el['id'];
            $el['user_id'] = $el['user_id'] !== null ? (int) $el['user_id'] : null;
            $el['updating_by_id'] = $el['updating_by_id'] !== null ? (int) $el['updating_by_id'] : null;
            $el['patient_id'] = (int) $el['patient_id'];
            $el['is_invoiced'] = $el['is_invoiced'] === 0 ? false : true;
            $el['is_updating'] = $el['is_updating'] === 0 ? false : true;
            $el['is_negative'] = $el['is_negative'] === 0 ? false : true;
            $el['tested_at'] = $el['tested_at'] !== null ? date_create($el['tested_at']) : null;
            $el['filled_at'] = $el['filled_at'] !== null ? date_create($el['filled_at']) : null;
            $el['start_updating'] = $el['start_updating'] !== null ? date_create($el['start_updating']) : null;

            return $el;
        }, $query->fetchAll());

    }
}

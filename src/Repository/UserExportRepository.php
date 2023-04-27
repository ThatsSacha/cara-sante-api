<?php

namespace App\Repository;

use App\Entity\UserExport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserExport>
 *
 * @method UserExport|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserExport|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserExport[]    findAll()
 * @method UserExport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserExportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserExport::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(UserExport $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(UserExport $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return UserExport[] Returns an array of UserExport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserExport
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function exportDataFrom(int $userId): array {
        $db = $this->getEntityManager()->getConnection();

        $query = 'SELECT
                dt.tested_at,
                dt.is_invoiced,
                dt.filled_at,
                dt.ref,
                dt.is_negative,
                dt.doctor_first_name,
                dt.doctor_last_name,
                dt.is_invoiced_on_amelipro,
                p.first_name AS patient_first_name,
                p.last_name AS patient_last_name,
                p.birth AS patient_birth_date,
                p.phone AS patient_phone,
                p.mail AS patient_mail,
                p.nir AS patient_nir,
                p.street AS patient_street,
                p.zip AS patient_zip,
                p.city AS patient_city,
                u.first_name AS user_first_name,
                u.last_name AS user_last_name,
                u2.first_name AS already_invoiced_by_first_name,
                u2.last_name AS already_invoiced_by_last_name
            FROM detection_test AS dt
            LEFT JOIN patient AS p
                ON dt.patient_id = p.id
            LEFT JOIN users AS u
                ON dt.user_id = u.id
            LEFT JOIN users AS u2
                ON dt.already_invoiced_by_id = u2.id
            WHERE dt.user_id = :val
        ';

        $query = $db->prepare($query);
        $query->bindValue('val', $userId);
        $response = $query->executeQuery();
        
        return $response->fetchAll();
    }
}

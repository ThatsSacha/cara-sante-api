<?php

namespace App\Repository;

use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    // /**
    //  * @return Patient[] Returns an array of Patient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Patient
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /*public function findAll() {
        $db = $this->getEntityManager()->getConnection();
        $query = 'SELECT * FROM patient';
        $d = $db->prepare($query);
        $d->executeQuery();

        return $d->fetchAll();
    }*/

    /**
     * @param string $value
     * 
     * @return array
     */
    public function search(string $value): array
    {
        $db = $this->getEntityManager()->getConnection();
        $query = 'SELECT * FROM patient WHERE
            first_name LIKE :value
        OR
            last_name LIKE :value
        OR
            mail LIKE :value
        OR
            nir LIKE :value
        OR
            zip LIKE :value
        OR
            city LIKE :value
        ';

        $d = $db->prepare($query);
        $d->executeQuery(array(
                ':value' => '%' . $value . '%'
            )
        );

        return $d->fetchAll();
    }
}

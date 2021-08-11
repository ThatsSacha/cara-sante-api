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
    private $emi;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $emi)
    {
        parent::__construct($registry, Patient::class);
        $this->emi = $emi;
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

    public function findAll() {
        $db = $this->getEntityManager()->getConnection();
        $query = 'SELECT * FROM patient';
        $d = $db->prepare($query);
        $d->executeQuery();

        return $d->fetchAll();
    }

    public function findToTake() {
        $db = $this->getEntityManager()->getConnection();
        $query = 'SELECT *, patient.id AS patient_patient_id FROM patient LEFT JOIN detection_test ON patient.id = detection_test.patient_id WHERE detection_test.is_invoiced = false LIMIT 20';
        $d = $db->prepare($query);
        $d->executeQuery();

        $requestMaped = array_map(function($el) {
            $el['id'] = (int) $el['patient_patient_id'];
            return $el;
        }, $d->fetchAll());

        return $requestMaped;
    }

    /*public function create(Patient $patient) {
        $db = $this->getEntityManager()->getConnection();
        $query = 'INSERT INTO patient (first_name, last_name, mail, phone, birth, street, zip, city, nir) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $d = $db->prepare($query);
        $d->executeQuery(array(
            $patient->getFirstName(),
            $patient->getLastName(),
            $patient->getMail(),
            $patient->getPhone(),
            date_format($patient->getBirth(), 'Y-m-d'),
            $patient->getStreet(),
            $patient->getZip(),
            $patient->getCity(),
            $patient->getNir()
        ));
    }*/
}

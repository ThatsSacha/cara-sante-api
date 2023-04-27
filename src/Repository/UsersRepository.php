<?php

namespace App\Repository;

use App\Entity\Users;
use IntlDateFormatter;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Users) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return Users[] Returns an array of Users objects
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
    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllWithDetectionTestCount($user) {
        $db = $this->getEntityManager()->getConnection();
        
        $query = 'SELECT id, first_name AS firstName, last_name as lastName, email AS mail, phone, last_login AS lastLogin, is_first_connection AS isFirstConnection, is_desactivated AS isDesactivated, ref FROM users WHERE id != :val';
        $query = $db->prepare($query);
        $query->bindValue('val', $user->getId());
        $response = $query->executeQuery();
        $users = $response->fetchAll();
        $tmp = [];

        foreach ($users as $key => $user) {
            $detectionTestCount = $this->countDetectionTestFor($user['id']);
            $tmp[] = $user;
            $tmp[$key]['totalInvoiced'] = $detectionTestCount['detection_test_count'];
            $tmp[$key]['lastLoginFrench'] = $user['lastLogin'] === null ? : IntlDateFormatter::formatObject(date_create($user['lastLogin']), IntlDateFormatter::RELATIVE_MEDIUM, 'fr');
        }

        return $tmp;
    }

    public function countDetectionTestFor(int $userId): array {
        $db = $this->getEntityManager()->getConnection();
        $query = "SELECT COUNT(*) AS detection_test_count FROM detection_test WHERE user_id = :val";

        $query = $db->prepare($query);
        $query->bindValue('val', $userId);
        $response = $query->executeQuery();

        return $response->fetchAll()[0];
    }
}

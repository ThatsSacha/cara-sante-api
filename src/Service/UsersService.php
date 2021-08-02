<?php

namespace App\Service;

use Exception;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersService extends AbstractRestService {
    private $passwordHasher;

    public function __construct(UsersRepository $repository, EntityManagerInterface $emi, DenormalizerInterface $denormalizer, UserPasswordHasherInterface $passwordHasher) {
        parent::__construct($repository, $emi, $denormalizer);

        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @param array $data
     * 
     * @return array
     */
    public function new(array $data): array {
        try {
            $mandatory = ['email', 'password'];
            $this->verifyMandatoryFields($mandatory, $data);
            $this->verifyMailFormat($data['email']);
            $data['password'] = $this->passwordHasher->hashPassword(new Users, $data['password']);
            $user = $this->create($data);

            return $user->jsonSerialize();
        } catch (Exception $e) {
            return array(
                'status' => 400,
                'message' => $e->getMessage()
            );
        }
    }

    public function verifyMailFormat(string $mail) {
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $this->throwError(["Le format de l'adresse mail est erroné"]);
        }
    }

    /**
     * @param array $mandatoryFields
     * @param array $data
     */
    public function verifyMandatoryFields(array $mandatoryFields, array $data): array {
        $error = array();

        foreach($mandatoryFields as $field) {
            if (!in_array($field, $mandatoryFields) || !isset($data[$field]) || empty($data[$field])) {
                $error[] = "$field est manquant ou vide";
            }
        }

        return count($error) > 0 ? $this->throwError($error) : [];
    }

    /**
     * @param array $errors
     * 
     * @throws Exception
     */
    public function throwError(array $errors) {
        if (count($errors) > 0) {
            $error = implode(', ', $errors);
            throw new Exception($error);
        }
    }
}
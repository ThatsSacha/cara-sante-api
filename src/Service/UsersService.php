<?php

namespace App\Service;

use Exception;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

date_default_timezone_set('Europe/Paris');

class UsersService extends AbstractRestService {
    private $passwordHasher;
    private $repository;

    public function __construct(UsersRepository $repository, EntityManagerInterface $emi, DenormalizerInterface $denormalizer, UserPasswordHasherInterface $passwordHasher) {
        parent::__construct($repository, $emi, $denormalizer);

        $this->passwordHasher = $passwordHasher;
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * 
     * @return array
     */
    public function new(array $data): array {
        try {
            $mandatory = ['email', 'password', 'firstName', 'lastName'];
            $this->verifyMandatoryFields($mandatory, $data);
            $this->verifyMailFormat($data['email']);
            $this->verifyUniqueMail($data['email']);
            $data['password'] = $this->passwordHasher->hashPassword(new Users, $data['password']);
            $data['createdAt'] = date('y-d-m H:i:s', time());

            $user = $this->create($data);

            return $user->jsonSerialize();
        } catch (Exception $e) {
            return array(
                'status' => 400,
                'message' => $e->getMessage()
            );
        }
    }

    /**
     * @param string $mail
     * 
     * @throws Exception
     */
    public function verifyUniqueMail(string $mail) {
        $users = $this->repository->findBy(array(
            'email' => $mail
        ));

        if (count($users) > 0) {
            $this->throwError(["Cette adresse mail est déjà utilisée"]);
        }
    }

    /**
     * @param string $mail
     * 
     * @throws Exception
     */
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
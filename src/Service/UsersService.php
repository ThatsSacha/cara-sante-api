<?php

namespace App\Service;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UsersService {
    private $denormalizer;
    private $emi;

    public function __construct(DenormalizerInterface $denormalizer, EntityManagerInterface $emi) {
        $this->denormalizer = $denormalizer;
        $this->emi = $emi;
    }

    public function create(array $data) {
        try {
            $mandatory = ['email', 'password'];
            $this->verifyMandatoryFields($mandatory, $data);
            $this->verifyMailFormat($data['email']);

            //$this->userPasswordHasher->hashPassword(
            $user = $this->denormalizer->denormalize($data, Users::class);
                $this->emi->persist($user);
                $this->emi->flush();

            return array(
                'status' => 201
            );
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

    public function verifyMandatoryFields(array $mandatoryFields, array $data): array {
        $error = array();

        foreach($mandatoryFields as $field) {
            if (!in_array($field, $mandatoryFields) || !isset($data[$field]) || empty($data[$field])) {
                $error[] = "$field est manquant ou vide";
            }
        }

        return count($error) > 0 ? $this->throwError($error) : [];
    }

    public function throwError(array $errors) {
        if (count($errors) > 0) {
            $error = implode(', ', $errors);
            throw new Exception($error);
        }
    }
}
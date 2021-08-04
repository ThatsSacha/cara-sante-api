<?php

namespace App\Service;

use App\Entity\Patient;
use App\Entity\Users;
use Exception;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DetectionTestRepository;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

date_default_timezone_set('Europe/Paris');

class DetectionTestService extends AbstractRestService {
    private $repository;

    public function __construct(DetectionTestRepository $repository, EntityManagerInterface $emi, DenormalizerInterface $denormalizer) {
        parent::__construct($repository, $emi, $denormalizer);

        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function findAll(): array {
        return $this->repository->findAll();
    }

    /**
     * @param int $id
     * 
     * @return array
     */
    public function findById(int $id): array
    {
        return $this->repository->findBy(array(
            'id' => $id
        ));
    }

    /**
     * @param int $id
     * 
     * @return array
     */
    public function findByPatientId(int $id): array
    {
        return $this->repository->findBy(array(
            'patient' => $id
        ));
    }

    public function createDetectionTest(Patient $createdPatient, array $patientObject, Users $user) {
        $data['patient'] = $createdPatient->getId();
        $data['user'] = $user->getId();
        $data['testedAt'] = $patientObject['testedAt'];

        dd($this->create($data));
    }

    /**
     * @param array $patientObject
     * @param Patient $patient
     * 
     * @return bool
     */
    public function detectionTestExists(array $patientObject, Patient $patient): bool {
        $id = $patient->getId();
        $detectionTests = $this->findByPatientId($id);
        
        if (count($detectionTests) > 0) {

        }

        return false;
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
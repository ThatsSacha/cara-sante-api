<?php

namespace App\Service;

use App\Entity\DetectionTest;
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

    public function createDetectionTest(array $createdPatient, $existing) {
        $data = [];
        foreach($existing as $el) {
            $data[]['patient'] = $el->getId();
            $data[]['testedAt'] = $createdPatient['testedAt'];
            
            //$row = $this->denormalizeData($data);
            
        }
        $this->create($data);
    }

    /**
     * @param array $patientObject
     * @param array $existingPatients
     * 
     * @return bool
     */
    public function detectionTestExists(array $patientObject, array $existingPatients): bool {
        //dd($patientObject, $existingPatients[$patientObject['mail']]);
        //dd('here');
        if (isset($existingPatients[$patientObject['nir']])) {
            foreach($existingPatients[$patientObject['nir']] as $existingPatient) {
                $patient = $existingPatient->jsonSerialize();
    
                if ($patient['detectionTest'] !== null) {
                    foreach($patient['detectionTest'] as $detectionTest) {
                        $patientObjectTestedAtDate = date_format(date_create($patientObject['testedAt']), 'Y-m-d H:i');
                        $detectionTestTestedAtDate = date_format($detectionTest['testedAt'], 'Y-m-d H:i');
            
                        if ($patientObjectTestedAtDate === $detectionTestTestedAtDate) {
                            return true;
                        }
                    }
                }
            }
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
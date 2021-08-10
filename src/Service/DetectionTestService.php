<?php

namespace App\Service;

use Exception;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DetectionTestRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

date_default_timezone_set('Europe/Paris');

class DetectionTestService extends AbstractRestService {
    private $repository;

    public function __construct(DetectionTestRepository $repository, EntityManagerInterface $emi, DenormalizerInterface $denormalizer, NormalizerInterface $normalizer) {
        parent::__construct($repository, $emi, $denormalizer, $normalizer);

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

    /**
     * @return array
     */
    public function getDetectionTests(): array {
        $detectionTests = $this->findAll();
        $detectionTestsInDb = [];

        foreach($detectionTests as $detectionTest) {
            $detectionTestsInDb[$detectionTest['ref']] = $detectionTest;
        }

        return array($detectionTests, $detectionTestsInDb);
    }
    
    /**
     * @param array $csvDetectionTests
     * @param array $createdPatients
     */
    public function createDetectionTests(array $csvDetectionTests, array $createdPatients) {
        $detectionTests = $this->getDetectionTests();
        
        if (count($detectionTests[0]) > 0) {
            $csvDetectionTests = $this->checkExistingDetectionTest($detectionTests[1], $csvDetectionTests);
        }

        foreach($csvDetectionTests as $i => $csvDetectionTest) {
            $csvDetectionTests[$i]['patient'] = (int) $createdPatients[$csvDetectionTest['nir']]['id'];
        }

        $this->createDetectionTest($csvDetectionTests);
    }

    /**
     * @param array $detectionTestsInDb
     * @param array $csvDetectionTests
     * 
     * @return array
     */
    public function checkExistingDetectionTest(array $detectionTestsInDb, array $csvDetectionTests): array {
        $detectionTestsToAdd = [];
        
        foreach($csvDetectionTests as $nir => $csvDetectionTest) {
            if (!array_key_exists($nir, $detectionTestsInDb)) {
                $detectionTestsToAdd[$csvDetectionTest['ref']] = $csvDetectionTest;
            }
        }

        return $detectionTestsToAdd;
    }

    /**
     * @return array
     */
    public function createDetectionTest(array $csvDetectionTests): array {
        return $this->createFromArray($csvDetectionTests);
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
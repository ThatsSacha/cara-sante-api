<?php

namespace App\Service;

use App\Entity\Users;
use Exception;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DetectionTestRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

date_default_timezone_set('Europe/Paris');

class DetectionTestService extends AbstractRestService {
    private $repository;
    private $emi;

    public function __construct(DetectionTestRepository $repository, EntityManagerInterface $emi, DenormalizerInterface $denormalizer, NormalizerInterface $normalizer) {
        parent::__construct($repository, $emi, $denormalizer, $normalizer);

        $this->repository = $repository;
        $this->emi = $emi;
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
    public function findByRef(string $ref): array
    {
        return $this->repository->findBy(array(
            'ref' => $ref
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

    /**
     * @return array
     */
    public function findToTake(): array {
        $detectionTests = $this->repository->findBy(array(
            'isInvoiced' => false
        ), null, 20);
        $detectionTestsSerialized = [];

        foreach($detectionTests as $detectionTest) {
            $detectionTestsSerialized[] = $detectionTest->jsonSerialize();
        }

        return $detectionTestsSerialized;
    }

    /**
     * @param string $ref
     * @param array $data
     * @param Users $user
     */
    public function updateDetectionTest(string $ref, array $data, Users $user) {
        $data['isInvoiced'] = true;

        if (!isset($data['filledAt']) || empty($data['filledAt'])) {
            $data['filledAt'] = date_create();
        } else {
            $data['filledAt'] = date_create($data['filledAt']);
        }

        $data['user'] = $user->getRef();

        $detectionTest = $this->getByRef($ref);

        if (!$detectionTest->getIsInvoiced()) {
            $detectionTest->setIsInvoiced($data['isInvoiced']);
            $detectionTest->setFilledAt($data['filledAt']);
            $detectionTest->setUser($user);
            $this->emi->persist($detectionTest);
            $this->emi->flush();

            return array(
                'status' => 200,
                $detectionTest->jsonSerialize()
            );
        }

        return array(
            'status' => 400,
            'message' => 'Ce test a déjà été saisit'
        );
    }

    /**
     * @param Users $user
     * 
     * @return array
     */
    public function findTaken(Users $user): array {
        $detectionTests = $this->repository->findBy(array(
            'isInvoiced' => true,
            'user' => $user->getId()
        ), array(
            'filledAt' => 'DESC'
        ));
        $detectionTestsSerialized = [];

        foreach($detectionTests as $detectionTest) {
            $detectionTestsSerialized[] = $detectionTest->jsonSerialize();
        }

        return $detectionTestsSerialized;
    }
}
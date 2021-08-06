<?php

namespace App\Service;

use Exception;
use App\Service\ParseCsvService;
use App\Service\UploadFileService;
use App\Service\AbstractRestService;
use App\Repository\PatientRepository;
use App\Service\DetectionTestService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

date_default_timezone_set('Europe/Paris');

class PatientService extends AbstractRestService {
    private $repository;
    private $parseCsvService;
    private $uploadFileService;
    private $detectionTestService;

    public function __construct(PatientRepository $repository, EntityManagerInterface $emi, DenormalizerInterface $denormalizer, ParseCsvService $parseCsvService, UploadFileService $uploadFileService, DetectionTestService $detectionTestService) {
        parent::__construct($repository, $emi, $denormalizer);

        $this->repository = $repository;
        $this->parseCsvService = $parseCsvService;
        $this->uploadFileService = $uploadFileService;
        $this->detectionTestService = $detectionTestService;
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
     * @param bool $import
     * @param UploadedFile $file
     * 
     * @return array
     */
    public function createPatient(bool $import, UploadedFile $file): array {
        try {
            $path = './uploads/csv';
            $fileName = $this->uploadFileService->upload($file, $path, ['csv']);
            $detectionTests = $this->parseCsvService->parseCsvToArray($fileName, $path)['lines'];

            if ($import) {
                $csvDetectionTest = [];
                $csvNir = [];
                // Empty last time write in file do prevent double values
                file_put_contents('./uploads/detection-test.log', '');

                foreach($detectionTests as $i => $detectionTest) {
                    $firstName = $detectionTest['patient_first_name'];
                    $lastName = $detectionTest['patient_usual_name'];
                    $mail = $detectionTest['patient_email'];
                    $phone = $detectionTest['patient_phone'];
                    $birth = $detectionTest['patient_birthday'];
                    $nir = $detectionTest['patient_nir'];
                    $ref= $detectionTest[' ref'];
                    $dateTime = $detectionTest['date_time'];
                    $mainAddress = $detectionTest['patient_main_address_address'];

                    if (!empty($nir)) {
                        $csvDetectionTest[$ref] = [
                            'ref' => $ref,
                            'nir' => $nir,
                            'testedAt' => $dateTime
                        ];

                        $csvNir[$detectionTest['patient_nir']] = [
                            'firstName' => $firstName,
                            'lastName' => $lastName,
                            'mail' => $mail,
                            'phone' => $phone,
                            'birth' => $birth,
                            'street' => $mainAddress,
                            'zip' => $detectionTest['patient_main_address_zip'],
                            'city' => $detectionTest['patient_main_address_city'],
                            'nir' => $nir,
                            'testedAt' => $dateTime
                        ];
                    } else {
                        $write = "\nNIR empty : $firstName $lastName - $phone - $mail";
                        file_put_contents('./uploads/detection-test.log', $write, FILE_APPEND);
                    }
                }

                $createdPatients = $this->createPatients($csvNir);
                $this->detectionTestService->createDetectionTests($csvDetectionTest, $createdPatients[1]);
            } else {
                $this->parseCsvService->writeToResult($detectionTests);
            }

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

    public function getPatients() {
        $patients = $this->findAll();
        $patientsInDb = [];

        foreach($patients as $patient) {
            $patientsInDb[$patient['nir']] = $patient;
        }

        return array($patients, $patientsInDb);
    }

    /**
     * @param array $csvPatients
     */
    public function createPatients(array $csvNir) {
        $patients = $this->getPatients();
        
        if (count($patients[0]) > 0) {
            $csvNir = $this->checkExistingPatient($patients[1], $csvNir);
        }

        $this->createFromArray($csvNir);

        return $this->getPatients();
    }

    /**
     * @param array $patientsInDb
     * @param array $csvNirs
     * 
     * @return array
     */
    public function checkExistingPatient(array $patientsInDb, array $csvNirs): array {
        $patientToAdd = [];
        
        foreach($csvNirs as $nir => $csvNir) {
            if (!array_key_exists($nir, $patientsInDb)) {
                $patientToAdd[$csvNir['nir']] = $csvNir;
            }
        }

        return $patientToAdd;
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
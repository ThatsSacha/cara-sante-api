<?php

namespace App\Service;

use Exception;
use App\Entity\Patient;
use App\Entity\Users;
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
        //try {
            $path = './uploads/csv';
            $fileName = $this->uploadFileService->upload($file, $path, ['csv']);
            $detectionTests = $this->parseCsvService->parseCsvToArray($fileName, $path)['lines'];

            if ($import) {
                // constuct patient array with nir as key
                // $this->createPatients($csvPatient);
                // $this->createDetectionTest();

                /* createPatient(csvPatient) {
                    $patients = $findAll();
                    // patients array -> nir as key

                    if ($patients count > 0)
                        $patientToAdd = $this->checkExistingPatient($patients, $csvPatient);
                
                    $this->add($csvPatient)
                }*/
            
                /*
                    checkExistingPatient($patients, $csvPatient) {
                        if array_key_exists $patients nir dans $csvPatient
                            return $csvPatient de $patients[nir]
                        return false
                    }
                */
                $csvDetectionTest = [];
                $csvNir = [];

                foreach($detectionTests as $i => $detectionTest) {
                    $firstName = $detectionTest['patient_first_name'];
                    $lastName = $detectionTest['patient_usual_name'];
                    $mail = $detectionTest['patient_email'];
                    $phone = $detectionTest['patient_phone'];
                    $birth = $detectionTest['patient_birthday'];

                    if (!empty($detectionTest['patient_nir'])) {
                        $csvDetectionTest[$detectionTest[' ref']] = [
                            'nir' => $detectionTest['patient_nir'],
                            'testedAt' => $detectionTest['date_time']
                        ];

                        $csvNir[$detectionTest['patient_nir']] = [
                            'firstName' => $firstName,
                            'lastName' => $lastName,
                            'mail' => $mail,
                            'phone' => $phone,
                            'birth' => $birth,
                            'street' => $detectionTest['patient_main_address_address'],
                            'zip' => $detectionTest['patient_main_address_zip'],
                            'city' => $detectionTest['patient_main_address_city'],
                            'nir' => $detectionTest['patient_nir'],
                            'testedAt' => $detectionTest['date_time']
                        ];
                    } else {
                        // write to log
                    }
                }

                $createdPatients = $this->createPatients($csvNir);
                $this->createDetectionTests($csvDetectionTest, $createdPatients[1]);
            } else {
                $this->parseCsvService->writeToResult($detectionTests);
            }

            return array(
                'status' => 201
            );
        /*} catch (Exception $e) {
            return array(
                'status' => 400,
                'message' => $e->getMessage()
            );
        }*/
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
     * @param array $csvDetectionTests
     * @param array $createdPatients
     */
    public function createDetectionTests(array $csvDetectionTests, array $createdPatients) {
        $detectionTests = $this->detectionTestService->findAll();
        $detectionTestsInDb = [];

        foreach($detectionTests as $detectionTest) {
            $detectionTestsInDb[$detectionTest['nir']] = $detectionTest;
        }
        
        /*if (count($detectionTests) > 0) {
            $csvDetectionTests = $this->checkExistingPatient($detectionTestsInDb, $csvDetectionTests);
        }*/

        foreach($csvDetectionTests as $i => $csvDetectionTest) {
            $csvDetectionTests[$i]['patient'] = (int) $createdPatients[$csvDetectionTest['nir']]['id'];
        }

        $this->detectionTestService->createDetectionTest($csvDetectionTests);
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
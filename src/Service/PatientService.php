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
            $patients = $this->parseCsvService->parseCsvToArray($fileName, $path)['lines'];

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
                $csvPatients = [];

                foreach($patients as $i => $patient) {
                    $nir = $patient['patient_nir'];

                    if (!empty($nir)) {
                        $csvPatients[$nir] = [
                            'firstName' => $patient['patient_first_name'],
                            'lastName' => $patient['patient_usual_name'],
                            'mail' => $patient['patient_email'],
                            'phone' => $patient['patient_phone'],
                            'birth' => $patient['patient_birthday'],
                            'street' => $patient['patient_main_address_address'],
                            'zip' => $patient['patient_main_address_zip'],
                            'city' => $patient['patient_main_address_city'],
                            'nir' => $nir,
                            'testedAt' => $patient['date_time']
                        ];
                    } else {
                        // write to log file patient with empty nir and dont add to $csvPatient
                    }
                }

                $this->createPatients($csvPatients);
            } else {
                $this->parseCsvService->writeToResult($patients);
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

    /**
     * @param array $csvPatients
     */
    public function createPatients(array $csvPatients) {
        $patients = $this->findAll();
        $patientsInDb = [];

        foreach($patients as $patient) {
            $patientsInDb[$patient['nir']] = $patient;
        }
        
        if (count($patientsInDb) > 0) {
            $csvPatients = $this->checkExistingPatient($patientsInDb, $csvPatients);
        }

        $this->createFromArray($csvPatients);
    }

    public function checkExistingPatient(array $patientsInDb, array $csvPatients) {
        $patientToAdd = [];
        
        foreach($csvPatients as $nir => $csvPatient) {
            if (!array_key_exists($nir, $patientsInDb)) {
                $patientToAdd[$csvPatient['nir']] = $csvPatient;
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
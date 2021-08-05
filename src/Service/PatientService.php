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
                // constuct patient array
                // $this->createPatients($patientArray);
                // $this->createDetectionTest();

                /* createPatient(patientArray) {
                    $patients = $findAll();

                    if ($patients count > 0)
                        $patientToAdd = $this->checkExistingPatient($atients, $patientArray);
                
                    $this->add($patientArray)
                }*/
            
                /*
                    checkExistingPatient($patients, $patientArray) {
                        // mettre en key nir pour les 2 tableaux
                    }
                */


                $createdPatient = null;
                $firstTimeCreate = false;
                $existingPatients = [];
                $foundPatients = $this->findExistingPatients();
                $patientObject = [];

                if (count($foundPatients) === 0) {
                    $firstTimeCreate = true;
                }

                foreach($patients as $i => $patient) {
                    //$existingPatients = $this->findExistingPatients();

                    $patientObject[] = [
                        'firstName' => $patient['patient_first_name'],
                        'lastName' => $patient['patient_usual_name'],
                        'mail' => $patient['patient_email'],
                        'phone' => $patient['patient_phone'],
                        'birth' => $patient['patient_birthday'],
                        'street' => $patient['patient_main_address_address'],
                        'zip' => $patient['patient_main_address_zip'],
                        'city' => $patient['patient_main_address_city'],
                        'nir' => $patient['patient_nir'],
                        'testedAt' => $patient['date_time']
                    ];

                    //if ($firstTimeCreate || !$this->usersExists($patientObject[$i], $existingPatients)) {
                        //$patientObject[$i]['birth'] = date_create($patientObject[$i]['birth']);
                        //dd($patientObject[$i]);
                        unset($patientObject[$i]['testedAt']);
                        //$row = $this->denormalizeData($patientObject[$i]);
                        //dd($row);
                        
                        //$this->create($patientObject[$i]);
                    //}
                }
                $this->create($patientObject);
               
                $existingPatients = $this->findExistingPatients();

                foreach($patientObject as $el) {
                    /*if (!$this->detectionTestExists($el, $existingPatients)) {
                        $this->detectionTestService->createDetectionTest($el, $existingPatients[$el['nir']]);
                    }*/
                    dd($existingPatients, $el);
                    $this->detectionTestService->createDetectionTest($el, $existingPatients[$el['nir']]);
                    
                }
                
                
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

    public function findExistingPatients() {
        $foundPatients = $this->findAll();

        $b = $this->denormalizeData($foundPatients);
        dd($foundPatients, $b);
        $existingPatients = [];

        foreach($foundPatients as $patient) {
            $patientSerialized = $patient->jsonSerialize();
            $existingPatients[$patientSerialized['nir']][] = $patient;
        }

        return $existingPatients;
    }

    /**
     * @param array $patient
     * @param array $existingPatients
     * 
     * @return bool
     */
    public function usersExists(array $patient, array $existingPatients): bool {
        if (isset($existingPatients[$patient['nir']])) {
            return true;
        }

        return false;
    }

    /**
     * @param array $patientObject
     * @param Patient $patient
     * 
     * @return bool
     */
    public function detectionTestExists(array $patientObject, array $existingPatients): bool {
        return $this->detectionTestService->detectionTestExists($patientObject, $existingPatients);
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
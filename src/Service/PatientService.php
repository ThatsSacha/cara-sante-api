<?php

namespace App\Service;

use App\Entity\Patient;
use App\Repository\PatientRepository;
use Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

date_default_timezone_set('Europe/Paris');

class PatientService extends AbstractRestService {
    private $repository;
    private $parseCsvService;
    private $uploadFileService;

    public function __construct(PatientRepository $repository, EntityManagerInterface $emi, DenormalizerInterface $denormalizer, ParseCsvService $parseCsvService, UploadFileService $uploadFileService) {
        parent::__construct($repository, $emi, $denormalizer);

        $this->repository = $repository;
        $this->parseCsvService = $parseCsvService;
        $this->uploadFileService = $uploadFileService;
    }

    public function createPatient(bool $import, UploadedFile $file) {
        try {
            $path = './uploads/csv';
            $fileName = $this->uploadFileService->upload($file, $path, ['csv']);
            $patients = $this->parseCsvService->parseCsvToArray($fileName, $path)['lines'];

            if ($import) {
                $foundPatients = $this->findAll();
                $existingPatients = [];

                foreach($foundPatients as $patient) {
                    $patientSerialized = $patient->jsonSerialize();
                    $existingPatients[$patientSerialized['mail']] = $patient;
                }

                foreach($patients as $patient) {
                    $patientObject = [
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
                    
                    if (!$this->isPatientTestExists($patientObject, $existingPatients)) {
                        $this->create($patientObject);
                    }
                }
            }

            return array(
                'status' => 200
            );
        } catch (Exception $e) {
            return array(
                'status' => 400,
                'message' => $e->getMessage()
            );
        }
    }

    public function isPatientTestExists(array $patient, array $existingPatients): bool {
        dd($existingPatients[$patient['mail']]);
        // get all $existingPatients where $patient['mail'] = $existingPatients['mail']

        /*$patient = $this->findBy(array(
            'mail' => $patient['mail'],
            'testedAt' => date_create($patient['testedAt'])
        ));

        if (count($patient) > 0) {
            return true;
        }

        return false;*/
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
<?php

namespace App\Service;

use Exception;
use App\Entity\Users;
use App\Service\ParseCsvService;
use App\Service\UploadFileService;
use App\Service\AbstractRestService;
use App\Repository\PatientRepository;
use App\Service\DetectionTestService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

date_default_timezone_set('Europe/Paris');
ini_set('memory_limit', '-1');

class PatientService extends AbstractRestService {
    public function __construct(
        private string $params,
        private PatientRepository $repository,
        private EntityManagerInterface $emi,
        private DenormalizerInterface $denormalizer,
        private ParseCsvService $parseCsvService,
        private UploadFileService $uploadFileService,
        private DetectionTestService $detectionTestService,
        private NormalizerInterface $normalizer
    ) {
        parent::__construct($repository, $emi, $denormalizer, $normalizer);
    }

    /**
     * @return array
     */
    public function findAll(): array {
        return $this->repository->findAll();
    }

    /**
     * @return array
     */
    public function findToTake(): array {
        return $this->detectionTestService->findToTake();
    }

    /**
     * @param int $id
     * 
     * @return array
     */
    public function findByRef(string $ref): array
    {
        $patient = $this->repository->findOneBy(array(
            'ref' => $ref
        ));
        $patientToReturn = [];

        if ($patient !== null) {
            $patientToReturn = $patient->jsonSerialize();

            foreach($patientToReturn['detectionTest'] as $i => $detectionTest) {
                $detectionTestMonth = date_format($detectionTest['testedAt'], 'm');
                $doctorLastName = $detectionTest['doctorLastName'];

                // To not load antigenic test from September for M RABET doctor
                /*if ($doctorLastName === 'M RABET' && $detectionTestMonth === '09') {
                    unset($patientToReturn['detectionTest'][$i]);
                }*/
            }

            $patientToReturn['detectionTest'] = array_values($patientToReturn['detectionTest']);
        }

        return $patientToReturn;
    }

    /**
     * @param bool $import
     * @param string|null $update
     * @param UploadedFile $file
     * 
     * @return array
     */
    public function createPatient(bool $import, string|null $update, UploadedFile $file): array {
        try {
            $path = './uploads/csv';
            $fileName = $this->uploadFileService->upload($file, $path, ['csv']);
            $detectionTests = $this->parseCsvService->parseCsvToArray($fileName, $path)['lines'];

            if ($import || $update !== null) {
                $csvDetectionTest = [];
                $csvNir = [];
                // Empty last time write in file do prevent double values
                file_put_contents('./uploads/detection-test.log', '');

                foreach($detectionTests as $i => $detectionTest) {
                    $medicalCenter = $this->params;
                    
                    if ($detectionTest['medical_center'] !== $medicalCenter) {
                        continue;
                    }

                    /*$firstName = $detectionTest['patient_first_name'];
                    $lastName = $detectionTest['patient_usual_name'];
                    $mail = $detectionTest['patient_email'];
                    $phone = $detectionTest['patient_phone'];
                    $birth = $detectionTest['patient_birthday'];
                    $nir = $detectionTest['patient_nir'];
                    $ref= $detectionTest[' ref'];
                    $dateTime = $detectionTest['date_time'];
                    $mainAddress = $detectionTest['patient_main_address_address'];
                    $isNegative = $detectionTest['result'] === 'N' ? true : false;
                    $doctorFirstName = $detectionTest['professional_first_name'];
                    $doctorLastName = $detectionTest['professional_last_name'];*/

                     
                    $firstName = $detectionTest['invoiced_by_first_name'];
                    $lastName = $detectionTest['invoiced_by_last_name'];
                    $dateTime = date_create($detectionTest['antigenic_date']);
                    $doctorFirstName = $detectionTest['doctor_first_name'] === 'NULL' ? null : $detectionTest['doctor_first_name'];
                    $doctorLastName = $detectionTest['doctor_last_name'] === 'NULL' ? null : $detectionTest['doctor_last_name'];
                    $birth = $detectionTest['birth'] === 'NULL' ? null : date_create($detectionTest['birth']);
                    $nir = $detectionTest['nir'];
                    $isNegative = (bool) $detectionTest['is_negative'];
                    $mail = $detectionTest['Mail'];
                    $phone = $detectionTest['phone'];
                    $street = $detectionTest['street'];
                    $zip = $detectionTest['zip'];
                    $city = $detectionTest['city'];
                    $ref = $detectionTest['ref'];
                    
                    if (!empty($firstName) && !empty($lastName) && !empty($nir) && $birth !== false && $dateTime !== false) {
                        $csvDetectionTest[$ref] = [
                            'ref' => $ref,
                            'nir' => $nir,
                            'testedAt' => $dateTime->format('Y-m-d'),
                            'isNegative' => $isNegative,
                            'doctorFirstName' => $doctorFirstName,
                            'doctorLastName' => $doctorLastName
                        ];
                        
                        $csvNir[$nir] = [
                            'firstName' => $firstName,
                            'lastName' => $lastName,
                            'mail' => $mail,
                            'phone' => $phone,
                            'birth' => $birth === null ? null : $birth->format('Y-m-d'),
                            'street' => $street,
                            'zip' => $zip,
                            'city' => $city,
                            'nir' => $nir,
                            'testedAt' => $dateTime->format('Y-m-d'),
                            'ref' => hash('crc32', time()) . '-' . uniqid() . '-' . uniqid()
                        ];
                    } else {
                        if (empty($firstName) || empty($lastName)) { $message = "Unknown name"; }
                        else if (empty($nir)) { $message = "Empty NIR"; }
                        else if ($birth === false) { $message = "Birth is false"; }
                        else if ($dateTime === false) { $message = "DateTime is false " . $detectionTest['antigenic_date'];}
                        else { $message = "Unknown error"; }
                        $write = "\n$message : $firstName $lastName";
                        file_put_contents('./uploads/detection-test.log', $write, FILE_APPEND);
                    }
                }

                if ($update !== null) {
                    if ($update === 'patient') {}
                    else if ($update === 'detectionTest') {
                        $this->detectionTestService->updateDetectionTestFromImport($csvDetectionTest);
                    }
                } else if ($import) {
                    //dd($csvDetectionTest);
                    $createdPatients = $this->createPatients($csvNir);
                    //dd($createdPatients, $csvNir);
                    $this->detectionTestService->createDetectionTests($csvDetectionTest, $createdPatients[1]);
                }
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
            $patientsInDb[$patient->getNir()] = $patient;
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
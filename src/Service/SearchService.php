<?php

namespace App\Service;

use App\Entity\Patient;
use App\Entity\Users;
use App\Repository\PatientRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SearchService extends AbstractRestService {
    private $patientRepository;
    private $serializer;

    public function __construct(PatientRepository $patientRepository, SerializerInterface $serializer)
    {
        $this->patientRepository = $patientRepository;
        $this->serializer = $serializer;
    }

    /**
     * @param array $data
     * @param Users $user
     * 
     * @return array
     */
    public function search(array $data, Users $user): array {
        $patients = $this->patientRepository->search($data['search']);
        $resp = array('status' => 200, 'results' => []);

        if (count($patients) > 0) {
            foreach($patients as $patient) {
                $patient['id'] = (int) $patient['id'];
                $patientSerialized = $this->serializer->deserialize(json_encode($patient), 'App\Entity\Patient', 'json');
                
                array_push($resp['results'], $patientSerialized->jsonSerialize());
            }
        }

        return $resp;
    }
}
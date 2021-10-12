<?php

namespace App\Service;

use App\Entity\Patient;
use App\Entity\Users;
use App\Repository\PatientRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SearchService extends AbstractRestService {
    private $patientRepository;
    private $ser;

    public function __construct(PatientRepository $patientRepository, SerializerInterface $ser)
    {
        $this->patientRepository = $patientRepository;
        $this->ser = $ser;
    }
    public function search(array $data, Users $user) {
        $patients = $this->patientRepository->search($data['search']);

        if (count($patients) > 0) {
            $patients[0]['id'] = (int) $patients[0]['id'];
            //dd($patients[0]);
            dd($this->ser->deserialize(json_encode($patients[0]), 'App\Entity\Patient', 'json'));
        }
    }
}
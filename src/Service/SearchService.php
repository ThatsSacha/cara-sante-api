<?php

namespace App\Service;

use App\Entity\Users;
use App\Repository\PatientRepository;
use App\Repository\SearchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SearchService extends AbstractRestService {
    private $patientRepository;
    private $serializer;

    public function __construct(PatientRepository $patientRepository, SearchRepository $searchRepository, SerializerInterface $serializer, EntityManagerInterface $emi, DenormalizerInterface $denormalizer, NormalizerInterface $normalizer)
    {
        parent::__construct($searchRepository, $emi, $denormalizer, $normalizer);

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
            $search = [];

            foreach($patients as $patient) {
                $patient['id'] = (int) $patient['id'];
                $patientSerialized = $this->serializer->deserialize(json_encode($patient), 'App\Entity\Patient', 'json');
                
                array_push($resp['results'], $patientSerialized->jsonSerialize());

                $search['searchedBy'] = $user->getId();
                $search['searchedAt'] = date_format(date_create(), 'Y-m-d H:i:s');
                $search['subject'] = $data['search'];
            }

            $this->create($search);
        }

        return $resp;
    }
}
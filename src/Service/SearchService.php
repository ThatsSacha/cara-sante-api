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
    private $searchRepository;

    public function __construct(PatientRepository $patientRepository, SearchRepository $searchRepository, SerializerInterface $serializer, EntityManagerInterface $emi, DenormalizerInterface $denormalizer, NormalizerInterface $normalizer)
    {
        parent::__construct($searchRepository, $emi, $denormalizer, $normalizer);

        $this->patientRepository = $patientRepository;
        $this->serializer = $serializer;
        $this->searchRepository = $searchRepository;
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

        $search = [];
        $search['searchedBy'] = $user->getId();
        $search['searchedAt'] = date_format(date_create(), 'Y-m-d H:i:s');
        $search['subject'] = $data['search'];
        $this->create($search);

        return $resp;
    }

    /**
     * @param Users $user
     * 
     * @return array
     */
    public function history(Users $user): array {
        $history = $this->searchRepository->findBy(
            array(
            'searchedBy' => $user
            ),
            array(
                'searchedAt' => 'DESC'
            ),
            50
        );

        $historyReturn = array();

        if (count($history) > 0) {
            foreach($history as $el) {
                $historyReturn[] = $el->jsonSerialize();
            }
        }

        return $historyReturn;
    }

    /**
     * @param array $data
     * 
     * @return void
     */
    public function deleteFromHistory(array $data): void {
        $data = $data['elToDelete'];

        if (count($data) > 0) {
            foreach($data as $id) {
                $this->delete($id);
            }
        }
    }
}
<?php

namespace App\Service;

use App\Entity\UserExport;
use App\Entity\Users;
use IntlDateFormatter;
use App\Repository\UserExportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UserExportService extends AbstractRestService {
    public function __construct(
        private UserExportRepository $repository,
        private EntityManagerInterface $emi,
        private DenormalizerInterface $denormalizer,
        private NormalizerInterface $normalizer
    ) {
        parent::__construct($repository, $emi, $denormalizer, $normalizer);
    }

    public function requestExport(string $userRef) {
        $userRepository = $this->emi->getRepository(Users::class);
        $user = $userRepository->findOneBy(['ref' => $userRef]);
        
        if ($user !== null) {
            $filePath = $this->buildExportFileOf($user);
            $userExport = new UserExport();
            $userExport->setRequestedBy($user)
                        ->setDataFrom($user)
                        ->setRequestedAt(new \DateTime())
                        ->setFilePath($filePath)
            ;

            $this->emi->persist($userExport);
            $this->emi->flush();

            return array(
                'status' => 200,
                'object' => $userExport->jsonSerialize()
            );
        } else {
            return array(
                'status' => 400,
                'message' => 'Cet utilisateur est introuvable.'
            );
        }
    }

    /**
     * @param Users $user
     * 
     * @return string the file path
     */
    private function buildExportFileOf(Users $user): string {
        $detectionTests = $this->repository->exportDataFrom($user->getId());

        $csvHeader = array(
            'Testé le',
            'Saisit le',
            'Est facturé',
            'Référence',
            'Résultat du test',
            'Médecin',
            'Facturé via AmeliPro',
            'Patient',
            'Date de naissance',
            'N° sécurité sociale',
            'Adresse',
            'Saisit par',
            'Précédemment facturé par'
        );
        $fileName = 'export_' . date('d-m-Y-H-i-s') . '.csv';
        $filePath = '../var/exports/' . $fileName;
        $fp = fopen($filePath, 'wb');
        fputs($fp, implode(';', $csvHeader));

        foreach($detectionTests as $detectionTest) {
            $tmp = [];

            $tmp[1] = IntlDateFormatter::formatObject(date_create($detectionTest['tested_at']), IntlDateFormatter::MEDIUM, 'fr');
            $tmp[2] = IntlDateFormatter::formatObject(date_create($detectionTest['filled_at']), IntlDateFormatter::MEDIUM, 'fr');
            $tmp[3] = $detectionTest['is_invoiced'] ? 'Oui' : 'Non';
            $tmp[4] = $detectionTest['ref'];
            $tmp[5] = $detectionTest['is_negative'] ? 'Négatif' : 'Positif';
            $tmp[6] = $detectionTest['doctor_first_name'] . ' ' . $detectionTest['doctor_last_name'];
            $tmp[7] = $detectionTest['is_invoiced_on_amelipro'] ? 'Oui' : 'Non';
            $tmp[8] = $detectionTest['patient_first_name'] . ' ' . $detectionTest['patient_last_name'];
            $tmp[9] = IntlDateFormatter::formatObject(date_create($detectionTest['patient_birth_date']), IntlDateFormatter::MEDIUM, 'fr');
            $tmp[10] = $detectionTest['patient_nir'];
            $tmp[11] = $detectionTest['patient_street'] . ' ' . $detectionTest['patient_zip'] . ' ' . $detectionTest['patient_city'];
            $tmp[12] = $detectionTest['user_first_name'] . ' ' . $detectionTest['user_last_name'];
            $tmp[13] = $detectionTest['already_invoiced_by_first_name'] === null ? 'Aucun' : $detectionTest['already_invoiced_by_first_name'] . ' ' . $detectionTest['already_invoiced_by_last_name'];

            $data = PHP_EOL . implode(';', $tmp);
            fputs($fp, $data);
        }

        fclose($fp);
        return $filePath;
    }
}
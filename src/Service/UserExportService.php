<?php

namespace App\Service;

use Exception;
use App\Entity\Users;
use IntlDateFormatter;
use App\Entity\UserExport;
use App\Repository\UserExportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    public function requestExport(Request $request, Users $requestedBy, string $dataFrom) {
        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
        }

        $userRepository = $this->emi->getRepository(Users::class);
        $user = $userRepository->findOneBy(['ref' => $dataFrom]);
        
        if ($user !== null) {
            $fileName = $this->buildExportFileOf($user, $data);
            $date = date_create('01-' . $data['month'] . '-' . $data['year']);
            $frenchMonth = ucfirst(IntlDateFormatter::formatObject($date, 'MMMM', 'fr'));

            $userExport = new UserExport();
            $userExport->setRequestedBy($requestedBy)
                        ->setDataFrom($user)
                        ->setRequestedAt(new \DateTime())
                        ->setFileName($fileName)
                        ->setRef(uniqid())
                        ->setRequestedPeriod($frenchMonth . ' ' . $data['year'])
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
     * @return string the file name
     */
    private function buildExportFileOf(Users $user, array $data): string {
        $startDate = $data['year'] . '-' . $data['month'] . '-01';
        // Get the last day of the month
        $endDate = date('Y-m-t', strtotime($startDate));
        $detectionTests = $this->repository->exportDataFrom($user->getId(), $startDate, $endDate);

        if (is_dir('../var/exports') === false) {
            mkdir('../var/exports');
        }

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

            $tmp[1] = IntlDateFormatter::formatObject(date_create($detectionTest['tested_at']), 'd MMMM y', 'fr');
            $tmp[2] = IntlDateFormatter::formatObject(date_create($detectionTest['filled_at']), 'd MMMM y', 'fr');
            $tmp[3] = $detectionTest['is_invoiced'] ? 'Oui' : 'Non';
            $tmp[4] = $detectionTest['ref'];
            $tmp[5] = $detectionTest['is_negative'] ? 'Négatif' : 'Positif';
            $tmp[6] = $detectionTest['doctor_first_name'] . ' ' . $detectionTest['doctor_last_name'];
            $tmp[7] = $detectionTest['is_invoiced_on_amelipro'] ? 'Oui' : 'Non';
            $tmp[8] = $detectionTest['patient_first_name'] . ' ' . $detectionTest['patient_last_name'];
            $tmp[9] = IntlDateFormatter::formatObject(date_create($detectionTest['patient_birth_date']), 'd MMMM y', 'fr');
            $tmp[10] = $detectionTest['patient_nir'];
            $address = $detectionTest['patient_street'] . ' ' . $detectionTest['patient_zip'] . ' ' . $detectionTest['patient_city'];
            $tmp[11] = str_replace(array("\r", "\n"), '', $address);
            $tmp[12] = $detectionTest['user_first_name'] . ' ' . $detectionTest['user_last_name'];
            $tmp[13] = $detectionTest['already_invoiced_by_first_name'] === null ? 'Aucun' : $detectionTest['already_invoiced_by_first_name'] . ' ' . $detectionTest['already_invoiced_by_last_name'];

            $data = PHP_EOL . implode(';', $tmp);
            fputs($fp, $data);
        }

        fclose($fp);
        return $fileName;
    }

    public function getExportsOf(string $userRef): array {
        $userRepository = $this->emi->getRepository(Users::class);
        $user = $userRepository->findOneBy(['ref' => $userRef]);
        
        if ($user !== null) {
            $userExports = $this->repository->findBy(['dataFrom' => $user->getId()], ['requestedAt' => 'DESC']);
            $tmp = [];

            foreach($userExports as $userExport) {
                $tmp[] = $userExport->jsonSerialize();
            }

            return array(
                'status' => 200,
                'object' => $tmp
            );
        }

        return array(
            'status' => 400,
            'message' => 'Cet utilisateur est introuvable.'
        );
    }

    public function deleteExport(string $dataFrom, string $userRef): array {
        $userExport = $this->repository->findOneBy(['ref' => $dataFrom]);

        if ($userExport !== null) {
            $canDelete = $userExport->getDataFrom()->getRef() === $userRef || $userExport->getRequestedBy()->getRef() === $userRef;

            if ($canDelete) {
                try {
                    unlink('../var/exports/' . $userExport->getFileName());
                } catch(Exception $e) {
                    $e;
                }
    
                $this->emi->remove($userExport);
                $this->emi->flush();
    
                return array(
                    'status' => 200,
                    'message' => 'L\'export a bien été supprimé.'
                );
            }
            
            return array(
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour supprimer cet export.'
            );
        }

        return array(
            'status' => 400,
            'message' => 'Cet export est introuvable.'
        );
    }

    public function downloadExport(string $exportRef, string $userRef): BinaryFileResponse|JsonResponse {
        $userExport = $this->repository->findOneBy(['ref' => $exportRef]);
        $canDownload = $userExport->getDataFrom()->getRef() === $userRef || $userExport->getRequestedBy()->getRef() === $userRef;

        if ($userExport !== null && $canDownload) {
            $file = '../var/exports/' . $userExport->getFileName();

            return new BinaryFileResponse($file, 200, [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="' . $userExport->getFileName() . '"'
            ]);
        }

        return new JsonResponse(array(
            'status' => 400,
            'message' => 'Cet export est introuvable.'
        ), 400);
    }

    /**
     * @param string $userRef
     * 
     * @return array
     */
    public function getAvailableMonth(string $userRef): array {
        $user = $this->emi->getRepository(Users::class)->findOneBy(['ref' => $userRef]);

        if ($user !== null) {
            $userExports = $this->repository->findAvailableMonths($user->getId());
            
            foreach($userExports as $i => $userExport) {
                $date = date_create('01-' . $userExport['month'] . '-2023');
                $frenchMonth = ucfirst(IntlDateFormatter::formatObject($date, 'MMMM', 'fr'));
                $userExports[$i]['text'] = $frenchMonth . ' ' . $userExport['year'];
            }

            return array(
                'status' => 200,
                'object' => $userExports
            );
        }

        return array(
            'status' => 400,
            'message' => 'Cet utilisateur est introuvable.'
        );
    }
}
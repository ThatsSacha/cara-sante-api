<?php

namespace App\Controller;

use App\Service\PatientService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/patient')]
class PatientController extends AbstractController
{
    private $service;
    
    public function __construct(PatientService $service)
    {
        $this->service = $service;
    }

    #[Route('', name: 'patient_index', methods: ['OPTIONS', 'GET'])]
    public function index(): JsonResponse
    {
        $patients = $this->service->findAll();

        return new JsonResponse($patients, 200);
    }

    #[Route('/to-take', name: 'patient_index', methods: ['OPTIONS', 'GET'])]
    public function toTake(): JsonResponse
    {
        $patients = $this->service->findToTake();

        return new JsonResponse($patients, 200);
    }

    #[Route('/import', name: 'patient_new_import', methods: ['OPTIONS', 'POST'])]
    public function import(Request $request): JsonResponse {
        $file = $request->files->get('file');
        // Import = true -> import data to db
        $import = strtolower($request->get('import')) === 'true' ? true : false;
        $import = $this->service->createPatient($import, $file);

        return new JsonResponse($import, $import['status']);
    }

    #[Route('/{id}', name: 'patient_show', methods: ['OPTIONS', 'GET'])]
    public function show(int $id): JsonResponse
    {
        $patients = $this->service->findById($id);
        $patient = [];

        if (count($patients) > 0) {
            $patient = $patients[0]->jsonSerialize();
        }

        return new JsonResponse($patient, 200);
    }
}

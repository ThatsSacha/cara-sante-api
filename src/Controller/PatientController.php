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

    #[Route('/', name: 'patient_index', methods: ['OPTIONS', 'GET'])]
    public function index(): JsonResponse
    {
        $patients = $this->service->findAll();
        $patientsSerialized = [];

        foreach ($patients as $patient) {
            $patientsSerialized[] = $patient->jsonSerialize();
        }

        return new JsonResponse($patientsSerialized, 200);
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
        $patientsSerialized = [];

        foreach ($patients as $patient) {
            $patientsSerialized[] = $patient->jsonSerialize();
        }

        return new JsonResponse($patientsSerialized, 200);
    }

    #[Route('/{id}', name: 'patient_edit', methods: ['OPTIONS', 'PUT'])]
    public function edit(int $id, Request $request): JsonResponse
    {
        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
        }

        $update = $this->service->updatePatient($id, $data);

        dd($update);

        return new JsonResponse($patientsSerialized, 200);
    }
}

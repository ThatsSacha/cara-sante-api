<?php

namespace App\Controller;

use App\Entity\DetectionTest;
use App\Form\DetectionTestType;
use App\Repository\DetectionTestRepository;
use App\Service\DetectionTestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/detection-test')]
class DetectionTestController extends AbstractController
{
    private $service;
    
    public function __construct(DetectionTestService $service)
    {
        $this->service = $service;
    }

    #[Route('', name: 'detection_test_index', methods: ['OPTIONS', 'GET'])]
    public function index(): JsonResponse
    {
        $detectionTests = $this->service->findAll();

        return new JsonResponse($detectionTests, 200);
    }

    #[Route('/{ref}', name: 'detection_test_show', methods: ['OPTIONS', 'GET'])]
    public function show(string $ref): JsonResponse
    {
        $detectionTests = $this->service->findByRef($ref);
        $detectionTest = [];

        if (count($detectionTests) > 0) {
            $detectionTest = $detectionTests[0]->jsonSerialize();
        }

        return new JsonResponse($detectionTest, 200);
    }

    #[Route('/{ref}', name: 'detection_test_update', methods: ['OPTIONS', 'PUT'])]
    public function update(string $ref, Request $request): JsonResponse
    {
        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
        }

        $detectionTests = $this->service->updateDetectionTest($ref, $data, $this->getUser());

        return new JsonResponse($detectionTests, $detectionTests['status']);
    }

    #[Route('/updating', name: 'detection_test_update', methods: ['OPTIONS', 'PUT'])]
    public function updating(Request $request): JsonResponse
    {
        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
        }

        $detectionTests = $this->service->updatingDetectionTest($data, $this->getUser());

        return new JsonResponse($detectionTests, $detectionTests['status']);
    }
}

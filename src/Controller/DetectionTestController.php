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

    #[Route('/{id}', name: 'detection_test_show', methods: ['OPTIONS', 'GET'])]
    public function show(int $id): JsonResponse
    {
        $detectionTests = $this->service->findById($id);
        $detectionTest = [];

        if (count($detectionTests) > 0) {
            $detectionTest = $detectionTests[0]->jsonSerialize();
        }

        return new JsonResponse($detectionTest, 200);
    }

    #[Route('/{id}', name: 'detection_test_update', methods: ['OPTIONS', 'PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
        }

        $detectionTests = $this->service->updateDetectionTest($id, $data, $this->getUser());

        return new JsonResponse($detectionTests, 200);
    }
}

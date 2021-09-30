<?php

namespace App\Controller;

use App\Service\CronService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/cron')]
class SaveDatabaseController extends AbstractController
{
    private $service;
    
    public function __construct(CronService $service)
    {
        $this->service = $service;
    }

    #[Route('/save-db/{token}', name: 'cron_save_db', methods: ['OPTIONS', 'GET'])]
    public function update(string $token): JsonResponse
    {
        /*if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
        }*/

        $detectionTests = $this->service->saveDatabase($token);

        return new JsonResponse($detectionTests, $detectionTests['status']);
    }
}
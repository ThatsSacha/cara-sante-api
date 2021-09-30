<?php

namespace App\Controller\Cron;

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
    public function saveDb(string $token): JsonResponse
    {
        $status = $this->service->saveDatabase($token);

        return new JsonResponse([], $status);
    }

    #[Route('/detection-test/set-updating/{token}', name: 'cron_set-updating', methods: ['OPTIONS', 'GET'])]
    public function setUpdating(string $token): JsonResponse
    {
        $status = $this->service->setUpdating($token);

        return new JsonResponse([], $status);
    }
}
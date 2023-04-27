<?php

namespace App\Controller;

use App\Entity\Users;
use App\Service\UsersService;
use App\Service\UserExportService;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/user-export')]
class UsersExportController extends AbstractController
{
    public function __construct(private UserExportService $service)
    { }

    #[Route('/request', name: 'user-export-request', methods: ['OPTIONS', 'POST'])]
    public function requestExport(Request $request): JsonResponse
    {
        $users = $this->service->requestExport($request, $this->getUser()->getRef());

        return new JsonResponse($users, $users['status']);
    }

    #[Route('', name: 'user-export-me', methods: ['OPTIONS', 'GET'])]
    public function getExports(): JsonResponse
    {
        $users = $this->service->getExportsOf($this->getUser()->getRef());

        return new JsonResponse($users, $users['status']);
    }

    #[Route('/{ref}', name: 'user-export-delete-me', methods: ['OPTIONS', 'DELETE'])]
    public function delete(string $ref): JsonResponse
    {
        $users = $this->service->deleteExport($ref);

        return new JsonResponse($users, $users['status']);
    }

    #[Route('/download/{ref}', name: 'user-export-download', methods: ['OPTIONS', 'GET'])]
    public function download(string $ref): mixed
    {
        return $this->service->downloadExport($ref, $this->getUser()->getRef());
    }

    #[Route('/available-months', name: 'user-export-available-month', methods: ['OPTIONS', 'GET'])]
    public function availableMonth(): JsonResponse
    {
        $months = $this->service->getAvailableMonth($this->getUser()->getRef());

        return new JsonResponse($months, $months['status']);
    }
}

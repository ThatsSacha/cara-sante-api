<?php

namespace App\Controller;

use App\Entity\Users;
use App\Service\UsersService;
use App\Repository\UsersRepository;
use App\Service\UserExportService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/user-export')]
class UsersExportController extends AbstractController
{
    public function __construct(private UserExportService $service)
    { }

    #[Route('/request', name: 'user-export-request', methods: ['OPTIONS', 'GET'])]
    public function requestExport(): JsonResponse
    {
        $users = $this->service->requestExport($this->getUser()->getRef());

        return new JsonResponse($users, $users['status']);
    }
}

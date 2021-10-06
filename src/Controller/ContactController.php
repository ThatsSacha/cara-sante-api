<?php

namespace App\Controller;

use App\Service\ContactService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/contact')]
class ContactController extends AbstractController
{
    private $service;

    public function __construct(ContactService $service)
    {
        $this->service = $service;
    }

    #[Route('', name: 'contact', methods: ['OPTIONS', 'POST'])]
    public function new(Request $request): JsonResponse
    {
        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
        }
        
        $ret = $this->service->contact($data, $this->getUser());

        return new JsonResponse($ret, $ret['status']);
    }
}

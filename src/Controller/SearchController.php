<?php

namespace App\Controller;

use App\Service\SearchService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/search')]
class SearchController extends AbstractController
{
    private $service;

    public function __construct(SearchService $service)
    {
        $this->service = $service;
    }

    #[Route('', name: 'search', methods: ['OPTIONS', 'POST'])]
    public function new(Request $request): JsonResponse
    {
        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
        }
        
        $ret = $this->service->search($data, $this->getUser());

        return new JsonResponse($ret, $ret['status']);
    }

    #[Route('/history', name: 'search-history', methods: ['OPTIONS', 'GET'])]
    public function history(): JsonResponse
    {
        $ret = $this->service->history($this->getUser());

        return new JsonResponse($ret, 200);
    }

    #[Route('', name: 'search-delete', methods: ['OPTIONS', 'DELETE'])]
    public function delete(Request $request): JsonResponse
    {
        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
        }

        $this->service->deleteFromHistory($data);

        return new JsonResponse([], 200);
    }
}

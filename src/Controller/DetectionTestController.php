<?php

namespace App\Controller;

use App\Entity\DetectionTest;
use App\Form\DetectionTestType;
use App\Repository\DetectionTestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/detection-test')]
class DetectionTestController extends AbstractController
{
    #[Route('/', name: 'detection_test_index', methods: ['GET'])]
    public function index(DetectionTestRepository $detectionTestRepository): Response
    {
        return $this->render('detection_test/index.html.twig', [
            'detection_tests' => $detectionTestRepository->findAll(),
        ]);
    }
}

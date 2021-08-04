<?php

namespace App\Controller;

use App\Entity\DetectionTest;
use App\Form\DetectionTestType;
use App\Repository\DetectionTestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/detection/test')]
class DetectionTestController extends AbstractController
{
    #[Route('/', name: 'detection_test_index', methods: ['GET'])]
    public function index(DetectionTestRepository $detectionTestRepository): Response
    {
        return $this->render('detection_test/index.html.twig', [
            'detection_tests' => $detectionTestRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'detection_test_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $detectionTest = new DetectionTest();
        $form = $this->createForm(DetectionTestType::class, $detectionTest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detectionTest);
            $entityManager->flush();

            return $this->redirectToRoute('detection_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('detection_test/new.html.twig', [
            'detection_test' => $detectionTest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'detection_test_show', methods: ['GET'])]
    public function show(DetectionTest $detectionTest): Response
    {
        return $this->render('detection_test/show.html.twig', [
            'detection_test' => $detectionTest,
        ]);
    }

    #[Route('/{id}/edit', name: 'detection_test_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DetectionTest $detectionTest): Response
    {
        $form = $this->createForm(DetectionTestType::class, $detectionTest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('detection_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('detection_test/edit.html.twig', [
            'detection_test' => $detectionTest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'detection_test_delete', methods: ['POST'])]
    public function delete(Request $request, DetectionTest $detectionTest): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detectionTest->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detectionTest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('detection_test_index', [], Response::HTTP_SEE_OTHER);
    }
}

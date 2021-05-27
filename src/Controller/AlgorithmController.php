<?php

namespace App\Controller;

use App\Entity\Algorithm;
use App\Form\AlgorithmFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AlgorithmController
 * @package App\Controller
 * @Route("/algorithm", name="algorithm_")
 */
class AlgorithmController extends AbstractController
{


    /**
     * @Route("/new", name="new")
     * @param Request $request
     * @IsGranted("ROLE_EDITOR")
     */
    public function new(Request $request): Response
    {
        $algorithm = new Algorithm();

        $form = $this->createForm(AlgorithmFormType::class, $algorithm);
        $form->handleRequest($request);
        echo $form->getErrors();
        if ($form->isSubmitted() && $form->isValid()) {
            $algorithm = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($algorithm);
            $entityManager->flush();
            $this->redirectToRoute('algorithm_success');
        }
        return $this->render('algorithm/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/success", name="success")
     */
    public function success() {
        // TODO implement success page
    }

    /**
     * @Route("/{name}", name="view")
     * @param Algorithm $algorithm
     * @return Response
     */
    public function index(Algorithm $algorithm): Response
    {

        return $this->render('algorithm/view.html.twig', [
            'algorithm' => $algorithm
        ]);
    }

    /**
     * @Route("/{name}/edit", name="edit")
     * @IsGranted("ROLE_EDITOR")
     * @param Algorithm $algorithm
     * @return Response
     */
    public function edit(Algorithm $algorithm) {
        return $this->render('algorithm/edit.html.twig', [
            'algorithm' => $algorithm
        ]);
    }
}
<?php

namespace App\Controller;

use App\Entity\Algorithm;
use App\Form\AlgorithmFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
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
     * @return Response
     * @IsGranted("ROLE_EDITOR")
     */
    public function new(Request $request): Response
    {
        $algorithm = new Algorithm();

        $form = $this->createForm(AlgorithmFormType::class, $algorithm);
        $form->handleRequest($request);
        echo $form->getErrors();
        if ($form->isSubmitted() && $form->isValid()) {
           $this->persistAlgorithm($form);
        }
        return $this->render('algorithm/editor.html.twig', [
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
     * @Route("/delete/{name}", name="delete")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $em
     * @param Algorithm $algorithm
     */
    public function delete(EntityManagerInterface $em, Algorithm $algorithm) {
        try {
            $em->remove($algorithm);
            $em->flush();
            return $this->redirectToRoute('app_home');
        } catch (ORMException $e) {
        }

    }

    /**
     * @Route("/{name}", name="view")
     * @param Algorithm $algorithm
     * @return Response
     */
    public function view(Algorithm $algorithm): Response
    {

        return $this->render('algorithm/view.html.twig', [
            'algorithm' => $algorithm
        ]);
    }

    /**
     * @Route("/edit/{name}", name="edit")
     * @IsGranted("ROLE_EDITOR")
     * @param Algorithm $algorithm
     * @return Response
     */
    public function edit(Algorithm $algorithm, Request $request) {
        $form = $this->createForm(AlgorithmFormType::class, $algorithm);
        $form->handleRequest($request);
        echo $form->getErrors();
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistAlgorithm($form);
        }
        return $this->render('algorithm/editor.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function persistAlgorithm($form) {
        $algorithm = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($algorithm);
        $entityManager->flush();
        $this->redirectToRoute('algorithm_success');
    }
}
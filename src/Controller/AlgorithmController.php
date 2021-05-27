<?php

namespace App\Controller;

use App\Entity\Algorithm;
use App\Entity\CategoryTag;
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
        $tag = new CategoryTag();
        $tag->setName("Hash Function");
        $tag->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam justo.");
        $tag->setColor(0xFF0000);
        $algorithm->getTags()->add($tag);

        $form = $this->createForm(AlgorithmFormType::class, $algorithm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

        }
        return $this->render('algorithm/new.html.twig', [
            'form' => $form->createView(),
        ]);
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
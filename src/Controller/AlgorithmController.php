<?php

namespace App\Controller;

use App\Entity\Algorithm;
use App\Form\AlgorithmFormType;
use App\Repository\AlgorithmRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
    public function success()
    {
        // TODO implement success page
    }

    /**
     * @Route("/delete/{name}", name="delete")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $em
     * @param Algorithm $algorithm
     */
    public function delete(EntityManagerInterface $em, Algorithm $algorithm)
    {
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
     * @param Request $request
     * @return Response
     */
    public function edit(Algorithm $algorithm, Request $request): Response
    {
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
     * @Route("/search/{name}")
     */
    public function search(AlgorithmRepository $repository, string $name): Response
    {
        $data = $repository->findByNameAutocomplete($name);
        return $this->json($data);
    }

    /**
     * @Route("/comments/{id}")
     * @param Algorithm $algorithm
     * @return JsonResponse
     */
    public function getComments(Algorithm $algorithm): JsonResponse
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);

        $data = $serializer->normalize($algorithm->getComments(), 'json', [
            'groups' => 'commentTreeGroup',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
            AbstractNormalizer::ATTRIBUTES => ['id', 'text', 'upvotes', 'user', 'parent' => ['id']]
        ]);

        return new JsonResponse($data);
    }

    /**
     * @param $form
     */
    private function persistAlgorithm($form)
    {
        $algorithm = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($algorithm);
        $entityManager->flush();
        $this->redirectToRoute('algorithm_success');
    }
}
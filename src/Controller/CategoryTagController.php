<?php

namespace App\Controller;

use App\Entity\CategoryTag;
use App\Form\CategoryTagFormType;
use App\Repository\CategoryTagRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CategoryTagController
 * @package App\Controller
 * @Route("/category", name="category_")
 */
class CategoryTagController extends AbstractController
{
    /**
     * @Route("/add", name="add")
     * @IsGranted("ROLE_EDITOR")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $categoryTag = new CategoryTag();

        $form = $this->createForm(CategoryTagFormType::class, $categoryTag);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistCategoryTag($form);
        }
        return $this->render('category/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/manage", name="manage")
     * @IsGranted("ROLE_EDITOR")
     * @param CategoryTagRepository $repository
     * @return Response
     */
    public function manage(CategoryTagRepository $repository): Response
    {
        $categories = $repository->findAll();

        return $this->render('category/manage.html.twig', [
           'categories' => $categories
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @IsGranted("ROLE_EDITOR")
     * @param CategoryTag $categoryTag
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function delete(CategoryTag $categoryTag, EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($categoryTag);
        $em->flush();
        return $this->redirectToRoute('category_manage');
    }

    /**
     * @Route("/edit/{id}", name="edit")
     * @IsGranted("ROLE_EDITOR")
     * @param CategoryTag $categoryTag
     */
    public function edit(Request $request, CategoryTag $categoryTag): Response
    {
        $form = $this->createForm(CategoryTagFormType::class, $categoryTag);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistCategoryTag($form);
        }
        return $this->render('category/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/algorithms", name="get_algorithms")
     * @param CategoryTag $categoryTag
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function getAlgorithmsByCategoryTag(CategoryTag $categoryTag): JsonResponse
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);

        $data = $serializer->normalize($categoryTag->getAlgorithms(), 'json', [
            'groups' => 'byCategoryGroup',
        ]);

        return new JsonResponse($data);
    }

    private function persistCategoryTag($form)
    {
        $categoryTag = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($categoryTag);
        $entityManager->flush();
    }
}

<?php

namespace App\Controller;

use App\Entity\CategoryTag;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/{id}/algorithms")
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
}

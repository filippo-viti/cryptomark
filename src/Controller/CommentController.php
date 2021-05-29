<?php

namespace App\Controller;

use App\Entity\Comment;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/{id}", name="comment")
     * @param Comment $comment
     */
    public function getCommentById(Comment $comment): Response
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);

        $data = $serializer->normalize($comment, 'json', [
            'groups' => 'commentTreeGroup',
            AbstractNormalizer::ATTRIBUTES => ['id', 'text', 'upvotes', 'user']
        ]);

        return new JsonResponse($data);
    }
}

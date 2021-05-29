<?php

namespace App\Controller;

use App\Repository\CategoryTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(CategoryTagRepository $repository): Response
    {
        $tags = $repository->findAll();

        return $this->render('home/view.html.twig', [
            'categories' => $tags
        ]);
    }
}

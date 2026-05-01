<?php

namespace App\Controller;

use App\Repository\Animals\AnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(AnimalRepository $animalRepository): Response
    {
        $animals = $animalRepository->findAll();

        return $this->render('home/index.html.twig', [
            'animals' => $animals,
        ]);
    }
}
<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AbstractController
{
    #[Route('/animals', name: 'animal_index')]
    public function index(AnimalRepository $animalRepository): Response
    {
        $animals = $animalRepository->findAll();

        return $this->render('animal/index.html.twig', [
            'animals' => $animals,
        ]);
    }

    #[Route('/animals/{id}', name: 'animal_detail')]
    public function detail(int $id, AnimalRepository $animalRepository): Response
    {
        $animal = $animalRepository->find($id);

        if (!$animal) {
            throw $this->createNotFoundException('Animal not found.');
        }

        return $this->render('animal/detail.html.twig', [
            'animal' => $animal,
        ]);
    }
}

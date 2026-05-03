<?php
 
namespace App\Controller\Animal;
 
use App\Repository\Animals\AnimalRepository;
use App\Repository\Animals\SpeciesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
 
class AnimalController extends AbstractController
{
    #[Route('/animals', name: 'animal_index')]
    public function index(Request $request, AnimalRepository $animalRepository, SpeciesRepository $speciesRepository): Response
    {
        $search    = $request->query->get('search');
        $speciesId = $request->query->get('species');
        $size      = $request->query->get('size');
        $gender    = $request->query->get('gender');
 
        $animals = $animalRepository->findByFilters(
            search: $search,
            speciesId: $speciesId ? (int) $speciesId : null,
            size: $size,
            gender: $gender,
        );
 
        $allSpecies = $speciesRepository->findAll();
 
        return $this->render('animal/index.html.twig', [
            'animals'    => $animals,
            'allSpecies' => $allSpecies,
            'search'     => $search,
            'speciesId'  => $speciesId,
            'size'       => $size,
            'gender'     => $gender,
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
 
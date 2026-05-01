<?php

namespace App\Controller\Profile;

use App\Entity\Profile\Profile;
use App\Form\ProfileType;
use App\Repository\Profile\ProfileRepository;
use App\Repository\AdoptionApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile_show')]
    public function show(ProfileRepository $profileRepository, AdoptionApplicationRepository $adoptionRepo): Response
    {
        $profile = $profileRepository->findOneBy([]);
        $adoptions = $adoptionRepo->findAll(); 

        return $this->render('profile/show.html.twig', [
            'profile' => $profile,
            'adoptions' => $adoptions,
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function edit(Request $request, ProfileRepository $profileRepository, EntityManagerInterface $entityManager): Response
    {
        $profile = $profileRepository->findOneBy([]);
        
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_profile_show');
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
            'profile' => $profile,
        ]);
    }
}
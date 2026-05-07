<?php

namespace App\Controller\Profile;

use App\Entity\Profile\Profile;
use App\Form\ProfileType;
use App\Repository\Profile\ProfileRepository;
use App\Repository\AdoptionApplicationRepository;
use App\Service\ProfileCompletenessService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile_show')]
    public function show(
        ProfileRepository $profileRepository, 
        AdoptionApplicationRepository $adoptionRepo,
        ProfileCompletenessService $completenessService
    ): Response {
        $user = $this->getUser();
        $profile = $profileRepository->findOneBy(['user' => $user]);
        
        // --- 1. SECURITY GATE (VOTER) ---
        // Can only be viewed if the Voter allows it (owner or Admin)
        if ($profile) {
            $this->denyAccessUnlessGranted('PROFILE_VIEW', $profile);
        }

        $adoptions = $profile ? $adoptionRepo->findBy(['user' => $user]) : [];

        return $this->render('profile/show.html.twig', [
            'profile' => $profile,
            'adoptions' => $adoptions,
            'isComplete' => $completenessService->isProfileComplete($profile),
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function edit(
        Request $request, 
        ProfileRepository $profileRepository, 
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();
        $profile = $profileRepository->findOneBy(['user' => $user]);

        if (!$profile) {
            $profile = new Profile();
            $profile->setUser($user);
        }

        // --- 2. SECURITY GATE (VOTER) ---
        // You can only edit if the Voter allows it
        $this->denyAccessUnlessGranted('PROFILE_EDIT', $profile);

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($profile);
            $entityManager->flush();

            return $this->redirectToRoute('app_profile_show');
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
            'profile' => $profile,
        ]);
    }
}
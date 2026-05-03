<?php

namespace App\Controller\Adoption;

use App\Entity\AdoptionApplication;
use App\Entity\Animals\Animal;
use App\Form\AdoptionApplicationType;
use App\Repository\AdoptionApplicationRepository;
use App\Repository\Profile\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class AdoptionController extends AbstractController
{
    #[Route('/adoption/apply/{id}', name: 'app_adoption_apply', methods: ['GET', 'POST'])]
    public function apply(
        Animal $animal,
        Request $request,
        ProfileRepository $profileRepository,
        AdoptionApplicationRepository $adoptionRepo,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();

        // Profile completeness gate
        $profile = $profileRepository->findOneBy([]);
        if (
            !$profile
            || !$profile->getFirstName()
            || !$profile->getLastName()
            || !$profile->getCity()
            || !$profile->getAddress()
            || !$profile->getHousingType()
        ) {
            $this->addFlash('warning', 'Please complete your profile before applying to adopt.');
            return $this->redirectToRoute('app_profile_edit');
        }

        // Duplicate prevention
        $existing = $adoptionRepo->findOneBy([
            'user'   => $user,
            'animal' => $animal,
        ]);
        if ($existing) {
            $this->addFlash('info', 'You have already applied to adopt ' . $animal->getName() . '.');
            return $this->redirectToRoute('animal_detail', ['id' => $animal->getId()]);
        }

        $application = new AdoptionApplication();
        $form = $this->createForm(AdoptionApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $application->setUser($user);
            $application->setAnimal($animal);
            $application->setStatus('pending');
            $application->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($application);
            $entityManager->flush();

            $this->addFlash('success', 'Your adoption application has been submitted!');
            return $this->redirectToRoute('animal_index');
        }

        return $this->render('adoption/new.html.twig', [
            'animal' => $animal,
            'form'   => $form->createView(),
        ]);
    }
}

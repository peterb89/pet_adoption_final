<?php

namespace App\Controller\Admin;

use App\Repository\AdoptionApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/applications')]
#[IsGranted('ROLE_ADMIN')]
class AdminApplicationController extends AbstractController
{
    /**
     * Lists all adoption applications for admin review.
     * Sorted by most recent first, with pending ones at the top.
     */
    #[Route('', name: 'admin_application_index', methods: ['GET'])]
    public function index(AdoptionApplicationRepository $repo): Response
    {
        $applications = $repo->findAllWithDetails();

        return $this->render('admin/application/index.html.twig', [
            'applications' => $applications,
        ]);
    }

    /**
     * Shows one application's full detail including applicant info and animal.
     */
    #[Route('/{id}', name: 'admin_application_show', methods: ['GET'])]
    public function show(int $id, AdoptionApplicationRepository $repo): Response
    {
        $application = $repo->find($id);

        if (!$application) {
            throw $this->createNotFoundException('Adoption application not found.');
        }

        return $this->render('admin/application/show.html.twig', [
            'application' => $application,
        ]);
    }

    /**
     * Approves or rejects an adoption application and redirects back to the list.
     */
    #[Route('/{id}/status/{action}', name: 'admin_application_change_status', methods: ['POST'])]
    public function changeStatus(
        int $id,
        string $action,
        AdoptionApplicationRepository $repo,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $application = $repo->find($id);

        if (!$application) {
            throw $this->createNotFoundException('Adoption application not found.');
        }

        if (!$this->isCsrfTokenValid('change_status_' . $id, $request->request->get('_token'))) {
            $this->addFlash('danger', 'Invalid security token.');
            return $this->redirectToRoute('admin_application_show', ['id' => $id]);
        }

        if ($action === 'approve') {
            $application->setStatus('approved');
            $this->addFlash('success', 'Application #' . $id . ' approved.');
        } elseif ($action === 'reject') {
            $application->setStatus('rejected');
            $this->addFlash('danger', 'Application #' . $id . ' rejected.');
        }

        $em->flush();

        return $this->redirectToRoute('admin_application_index');
    }
}
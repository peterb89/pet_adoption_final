<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Profile\ProfileCrudController;
use App\Controller\Admin\Profile\HousingTypeCrudController;
use App\Controller\Admin\Authentification\UserCrudController;
use App\Controller\Admin\Animals\AnimalCrudController;
use App\Controller\Admin\Animals\AnimalTagCrudController;
use App\Controller\Admin\Animals\SpeciesCrudController;
use App\Controller\Admin\Animals\TagCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        // Tech Lead Fix: Redirecting to Profiles as the primary view for this Sprint
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProfileCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Pet Adoption Platform');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', \App\Entity\User::class);

        yield MenuItem::section('Profiles');
        yield MenuItem::linkToCrud('Profiles', 'fas fa-user', \App\Entity\Profile\Profile::class);
        yield MenuItem::linkToCrud('Housing Types', 'fas fa-house-user', \App\Entity\Profile\HousingType::class);

        yield MenuItem::section('Animals');
        yield MenuItem::linkToCrud('Animals', 'fas fa-paw', \App\Entity\Animals\Animal::class);
        yield MenuItem::linkToCrud('Animal Tags', 'fas fa-tags', \App\Entity\Animals\AnimalTag::class);
        yield MenuItem::linkToCrud('Species', 'fas fa-dna', \App\Entity\Animals\Species::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-tag', \App\Entity\Animals\Tag::class);
    }
}
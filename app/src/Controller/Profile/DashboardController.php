<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Profile\ProfileCrudController;
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
        yield MenuItem::linkToRoute('Users List', 'fas fa-users', 'admin_user_index');

        yield MenuItem::section('Profiles');
        yield MenuItem::linkToRoute('Profiles', 'fas fa-user', 'admin_profile_index');
        yield MenuItem::linkToRoute('Housing Types', 'fas fa-house-user', 'admin_housing_type_index');

        yield MenuItem::section('Animals');
        yield MenuItem::linkToRoute('Animals List', 'fas fa-paw', 'admin_animal_index');
        yield MenuItem::linkToRoute('Species', 'fas fa-dna', 'admin_species_index');
        yield MenuItem::linkToRoute('Tags', 'fas fa-tag', 'admin_tag_index');
    }
}

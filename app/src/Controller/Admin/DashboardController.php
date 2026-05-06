<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

// Kontrollerek importálása (Hogy a linkTo ismerje őket)
use App\Controller\Admin\Authentification\UserCrudController;
use App\Controller\Admin\Authentification\Profile\ProfileCrudController;
use App\Controller\Admin\Authentification\Profile\HousingTypeCrudController;
use App\Controller\Admin\Animals\AnimalCrudController;
use App\Controller\Admin\Animals\AnimalTagCrudController;
use App\Controller\Admin\Animals\SpeciesCrudController;
use App\Controller\Admin\Animals\TagCrudController;
use App\Controller\Admin\Animals\AnimalCommentCrudController;
use App\Controller\Admin\Adoption\AdoptionApplicationCrudController;
use App\Controller\Admin\Navigation\NavigationItemCrudController;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(AnimalCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Pet Adoption Platform');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Users');
        yield MenuItem::linkTo(UserCrudController::class, 'Users', 'fas fa-users');

        yield MenuItem::section('Profiles');
        yield MenuItem::linkTo(ProfileCrudController::class, 'Profiles', 'fas fa-user');
        yield MenuItem::linkTo(HousingTypeCrudController::class, 'Housing Types', 'fas fa-home');
        yield MenuItem::linkTo(AdoptionApplicationCrudController::class, 'Adoption Requests', 'fas fa-file-contract');

        yield MenuItem::section('Animals');
        yield MenuItem::linkTo(AnimalCrudController::class, 'Animals', 'fas fa-paw');
        yield MenuItem::linkTo(AnimalCommentCrudController::class, 'Comments', 'fas fa-comments');
        yield MenuItem::linkTo(AnimalTagCrudController::class, 'Animal Tags', 'fas fa-tags');
        yield MenuItem::linkTo(SpeciesCrudController::class, 'Species', 'fas fa-dna');
        yield MenuItem::linkTo(TagCrudController::class, 'Tags', 'fas fa-tag');

        yield MenuItem::section('Site Structure');
        yield MenuItem::linkTo(NavigationItemCrudController::class, 'Navigation Links', 'fas fa-list');
    }
}
<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

use App\Controller\Admin\Authentification\UserCrudController;

use App\Controller\Admin\Authentification\Profile\ProfileCrudController;
use App\Controller\Admin\Authentification\Profile\HousingTypeCrudController;

use App\Controller\Admin\Animals\AnimalCrudController;
use App\Controller\Admin\Animals\AnimalTagCrudController;
use App\Controller\Admin\Animals\SpeciesCrudController;
use App\Controller\Admin\Animals\TagCrudController;
use App\Controller\Admin\Animals\AnimalCommentCrudController;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        $url = $adminUrlGenerator
            ->setController(AnimalCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('App');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::section('Users');
        yield MenuItem::linkToRoute('Users', 'fas fa-users', 'admin_user_index');

        yield MenuItem::section('Profiles');
        yield MenuItem::linkToRoute('Profiles', 'fas fa-user', 'admin_profile_index');
        yield MenuItem::linkToRoute('Housing Types', 'fas fa-home', 'admin_housing_type_index');

        yield MenuItem::section('Animals');
        yield MenuItem::linkToRoute('Animals', 'fas fa-paw', 'admin_animal_index');
        yield MenuItem::linkToRoute('Comments', 'fas fa-comments', 'admin_animal_comment_index');
        yield MenuItem::linkToRoute('Animal Tags', 'fas fa-tags', 'admin_animal_tag_index');
        yield MenuItem::linkToRoute('Species', 'fas fa-dna', 'admin_species_index');
        yield MenuItem::linkToRoute('Tags', 'fas fa-tag', 'admin_tag_index');
    }
}

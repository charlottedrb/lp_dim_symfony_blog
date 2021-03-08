<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Blog');
    }

    public function configureMenuItems(): iterable
    {
        return [
            // Site
            MenuItem::section('Site'),
            MenuItem::linkToRoute('Home', 'fa fa-link', 'home'),

            MenuItem::section('Dashboard'),
            MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),

            // Users
            MenuItem::section('Users'),
            MenuItem::linkToCrud('Users', 'fa fa-users', User::class),

            // Posts
            MenuItem::section('Posts'),
            MenuItem::linkToCrud('Posts', 'fa fa-file-alt', Post::class),

            // Comments
            MenuItem::section('Comments'),
            MenuItem::linkToCrud('Comments', 'fa fa-comments', Comment::class),
        ];
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}

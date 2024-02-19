<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Genre;
use App\Entity\Song;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        
    }



    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $url = $this->adminUrlGenerator
            ->setController(GenreCrudController::class)
            ->generateUrl();

        return $this->redirect($url);

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="/images/logo2.png" style="width:30px; heighy:30px"><span class="text-small">Spotify</span>')
            ->setFaviconPath('/images/logo2.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Gestion Discographie');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::subMenu('Gestion Catégories', 'fa fa-star')->setSubItems([
            MenuItem::linkToCrud('catégorie', 'fa fa-plus', Genre::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les catégories', 'fa fa-eye', Genre::class)
        ]);
        yield MenuItem::subMenu('Gestion Albums', 'fa fa-star')->setSubItems([
            MenuItem::linkToCrud('Ajouter un album', 'fa fa-plus', Album::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les albums', 'fa fa-eye', Album::class)
        ]);
        yield MenuItem::subMenu('Gestion Chansons', 'fa fa-star')->setSubItems([
            MenuItem::linkToCrud('Ajouter une chanson', 'fa fa-plus', Song::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les chansons', 'fa fa-eye', Song::class)
        ]);
        yield MenuItem::subMenu('Gestion Artistes', 'fa fa-star')->setSubItems([
            MenuItem::linkToCrud('Ajouter un artiste', 'fa fa-plus', Artist::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les artistes', 'fa fa-eye', Artist::class)
        ]);
    }
}

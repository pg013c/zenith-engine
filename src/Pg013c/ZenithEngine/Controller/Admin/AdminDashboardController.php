<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Pg013c\ZenithEngine\Entity\ProductAttribute;
use Pg013c\ZenithEngine\Entity\ProductCategory;
use Pg013c\ZenithEngine\Entity\ProductOffer;
use Pg013c\ZenithEngine\Entity\ProductTemplate;
use Pg013c\ZenithEngine\Entity\ProductValue;
use Pg013c\ZenithEngine\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminDashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
//        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');

        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Www');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Clients');
        yield MenuItem::linkToCrud('Users', 'fas fa-list', User::class);

        yield MenuItem::section('Store');
        yield MenuItem::linkToCrud('Product offers', 'fas fa-list', ProductOffer::class);

        yield MenuItem::section('Configuration');
        yield MenuItem::linkToCrud('Product Categories', 'fas fa-list', ProductCategory::class);
        yield MenuItem::linkToCrud('Product Templates', 'fas fa-list', ProductTemplate::class);
        yield MenuItem::linkToCrud('Product Attributes', 'fas fa-list', ProductAttribute::class);
        yield MenuItem::linkToCrud('Product Values', 'fas fa-list', ProductValue::class);

        yield MenuItem::section('...');
        yield MenuItem::linkToLogout('Logout', 'fa fa-exit');
    }
}

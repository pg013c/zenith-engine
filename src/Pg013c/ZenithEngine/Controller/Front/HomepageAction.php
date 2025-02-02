<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageAction extends AbstractController
{
    #[Route('/', name: 'front_home')]
    public function __invoke(): Response
    {
        return $this->render('public/front/home.html.twig');
    }
}
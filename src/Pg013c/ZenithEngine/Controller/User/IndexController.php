<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/user/index', name: 'user_index')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }
}
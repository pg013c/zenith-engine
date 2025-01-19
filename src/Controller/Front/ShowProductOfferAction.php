<?php

declare(strict_types=1);

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShowProductOfferAction extends AbstractController
{
    #[Route('/product/{id}', name: 'product_show')]
    public function __invoke(int $id): Response
    {
        return $this->render('product/show.html.twig');
    }
}
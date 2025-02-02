<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Pg013c\ZenithEngine\Entity\ProductOffer;

class ProductOfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductOffer::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

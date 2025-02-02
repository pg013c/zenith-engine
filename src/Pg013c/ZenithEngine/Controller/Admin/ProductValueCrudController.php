<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Pg013c\ZenithEngine\Entity\ProductValue;

class ProductValueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductValue::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            AssociationField::new('productAttribute'),
        ];
    }
}

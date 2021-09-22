<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return array_merge(
            [
                ImageField::new('poster')
                    ->setUploadDir('./public/images')
                    ->setBasePath('images'),
                AssociationField::new('place'),
            ],
            parent::configureFields($pageName)
        );
    }
}

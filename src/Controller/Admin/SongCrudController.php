<?php

namespace App\Controller\Admin;

use App\Entity\Song;
use App\Repository\SongRepository;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Menu\CrudMenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SongCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Song::class;
    }
    
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre de la chanson'),
            ImageField::new('ffilePath', 'Choisir mp3')
                ->setBasePath('/upload/files/music')
                ->setUploadDir('public/upload/files/music')
                ->hideOnIndex()
                ->hideOnDetail(),
            TextField::new('ffilePath', 'Aperçu')
                ->hideOnForm()
                ->formatValue(function ($value, $entity) {
                    return '<audio controls>
                                <source src="/upload/files/music/' . $value . '" type="audio/mpeg">
                            </audio>';
                }),
            NumberField::new('duration', 'durée du titre'),
            AssociationField::new('album', 'Album associé'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW,
               fn(Action $action) => $action->setIcon('fa fa-add')->setLabel('Ajouter')->setCssClass('btn btn-success'))
            ->update(Crud::PAGE_INDEX, Action::EDIT,
               fn(Action $action) => $action->setIcon('fa fa-pen')->setLabel('Modifier'))
            ->update(Crud::PAGE_INDEX, Action::DELETE,
               fn(Action $action) => $action->setIcon('fa fa-trash')->setLabel('Supprimer'))
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL,
                fn(Action $action) => $action->setIcon('fa fa-info')->setLabel('information'))
            
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN,
               fn(Action $action) => $action->setLabel('Enregistrer et quitter'))
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE,
               fn(Action $action) => $action->setLabel('Enregistrer et continuer'))

            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN,
               fn(Action $action) => $action->setLabel('Enregistrer'))
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER,
               fn(Action $action) => $action->setLabel('Enregistrer et ajouter un nouveau'));
            

            
    }
}

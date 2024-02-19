<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AlbumCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Album::class;
    }

    public const ALBUM_BASE_PATH= 'upload/images/albums';

    public const ALBUM_UPLOAD_DIR = "public/upload/images/albums";

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre de l\'album'),
            

            AssociationField::new('genre', 'Catégorie de l\'album'),
            AssociationField::new('artist', 'Nom de l\'artiste'),
            ImageField::new('imagePath', 'Choisir une image de couverture')
                ->setBasePath(self::ALBUM_BASE_PATH)
                ->setUploadDir(self::ALBUM_UPLOAD_DIR)
                ->setUploadedFileNamePattern(
                    fn(UploadedFile $file): string => sprintf(
                        'upload_%d_%s.%s',
                        random_int(1, 999),
                        $file->getFilename(),
                        $file->guessExtension()
                    )),
            DateField::new('releaseDate', 'Date de sortie'),
            DateField::new('createdAt')->hideOnForm(),
            DateField::new('updatedAt')->hideOnForm(),
        ];
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Album) return;
        $entityInstance->setCreatedAt(new DateTimeImmutable());
        parent::persistEntity($em, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Album) return;
        $entityInstance->setUpdateAt(new DateTimeImmutable());
        parent::updateEntity($em, $entityInstance);
    }
    
}

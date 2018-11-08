<?php
namespace AppBundle\Admin;

use Application\Sonata\MediaBundle\Entity\Media;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Livre', ['class' => 'col-md-7'])
                ->add('title', TextType::class, [
                    'label' => 'Titre'
                ])
                ->add('bookHasMedias', CollectionType::class, [
                    'by_reference' => false,
                    'label' => 'Contenu numérique'
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                    'admin_code' => 'custom.media.admin.book_has_media'
                ])
            ->end()
            ->with('Détails', ['class' => 'col-md-5'])
                ->add('coverImage', AdminType::class, [
                    'label' => 'Image de couverture'
                ])
                ->add('publishAt', DateType::class, [
                    'format' => 'ddMMyyyy',
                    'label' => 'Publié le',
                    'years' => range(1955, date('Y'))
                ])
                ->add('author', TextType::class, [
                    'label' => 'Auteur'
                ])
                ->add('summary', TextareaType::class, [
                    'label' => 'Résumé'
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title');
    }

    public function toString($object)
    {
        return $object instanceof Post
            ? $object->getTitle()
            : 'Livre'; // shown in the breadcrumb on the create view
    }

}
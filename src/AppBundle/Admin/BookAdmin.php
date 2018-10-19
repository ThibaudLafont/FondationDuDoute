<?php
namespace AppBundle\Admin;

use Application\Sonata\MediaBundle\Entity\Gallery;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;

class BookAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Livre', ['class' => 'col-md-9'])
                ->add('title')
                ->add('gallery', ModelType::class, [
                    'class' => Gallery::class,
                    'property' => 'name'
                ])
            ->end()
            ->with('Détails', ['class' => 'col-md-3'])
                ->add('publishAt')
                ->add('author')
                ->add('summary')
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
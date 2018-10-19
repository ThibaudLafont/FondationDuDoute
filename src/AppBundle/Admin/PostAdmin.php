<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Contenu', ['class' => 'col-md-9'])
                ->add('title', TextType::class)
                ->add('content', TextType::class)
            ->end()
            ->with('Meta', ['class' => 'col-md-3'])
                ->add('category', ModelType::class, [
                    'class' => Category::class,
                    'property' => 'name'
                ])
            ->end()
            ->with('Gallerie')
                ->add('gallery', ModelType::class, [
                    'class' => Gallery::class,
                    'property' => 'name'
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title')
            ->add('category.name');
    }

    public function toString($object)
    {
        return $object instanceof Post
            ? $object->getTitle()
            : 'Post'; // shown in the breadcrumb on the create view
    }
}

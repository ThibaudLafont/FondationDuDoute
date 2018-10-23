<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class WebsiteAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('coverImage', AdminType::class, [
                'label' => 'Image de couverture'
            ])
            ->add('artistName', TextType::class, [
                'label' => 'Nom de l\'artiste'
            ])
            ->add('websiteUrl', UrlType::class, [
                'label' => "URL du site"
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('artistName');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('artistName')
            ->add('websiteUrl');
    }

    public function toString($object)
    {
        return $object instanceof Post
            ? $object->getArtistName()
            : 'Site'; // shown in the breadcrumb on the create view
    }
}
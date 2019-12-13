<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Website;
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
            ->with('Site Web', ['class' => 'col-md-7'])
                ->add('artistFirstName', TextType::class, [
                    'label' => 'Prénom de l\'artiste'
                ])
                ->add('artistLastName', TextType::class, [
                    'label' => 'Nom de l\'artiste'
                ])
                ->add('websiteUrl', UrlType::class, [
                    'label' => "URL du site"
                ])
            ->end()
            ->with('Détail', ['class' => 'col-md-5'])
                ->add('coverImage', AdminType::class, [
                    'label' => 'Image de couverture'
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('artistLastName');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('artistFirstName', null, ['label' => 'Prénom'])
            ->addIdentifier('artistLastName', null, ['label' => 'Nom'])
            ->add('websiteUrl', null, ['label' => 'URL du site']);
    }

    public function toString($object)
    {
        return $object instanceof Website
            ? $object->getArtistLastName()
            : 'Site'; // shown in the breadcrumb on the create view
    }
}
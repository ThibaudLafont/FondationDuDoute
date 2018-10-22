<?php
namespace Application\Sonata\MediaBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PostHasSongAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
        $link_parameters['hide_context'] = true;
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $link_parameters = [];

        if ($this->hasParentFieldDescription()) {
            $link_parameters = $this->getParentFieldDescription()->getOption('link_parameters', []);
        }

        // Limit the type of medias during browsing
        $link_parameters['mediaType'] = 'audio';

        $formMapper
            ->add('media', ModelListType::class, ['required' => false], [
                'link_parameters' => $link_parameters
            ])
            ->add('position', HiddenType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('media')
            ->add('post')
            ->add('position')
            ->add('enabled')
        ;
    }
}

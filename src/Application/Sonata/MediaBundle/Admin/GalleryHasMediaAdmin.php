<?php
namespace Application\Sonata\MediaBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class GalleryHasMediaAdmin extends \Sonata\MediaBundle\Admin\GalleryHasMediaAdmin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $link_parameters = [];

        if ($this->hasParentFieldDescription()) {
            $link_parameters = $this->getParentFieldDescription()->getOption('link_parameters', []);
        }

        if ($this->hasRequest()) {
            $context = $this->getRequest()->get('context', null);

            if (null !== $context) {
                $link_parameters['context'] = $context;
            }
        }

        $formMapper
            ->add('media', ModelListType::class, ['required' => false], [
                'link_parameters' => $link_parameters,
            ])
            ->add('position', HiddenType::class)
        ;
    }
}
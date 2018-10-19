<?php
namespace Application\Sonata\MediaBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GalleryAdmin extends \Sonata\MediaBundle\Admin\GalleryAdmin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        // define group zoning
        $formMapper
            ->with('Gallerie', ['class' => 'col-md-9'])->end()
            ->with('Détail', ['class' => 'col-md-3'])->end()
        ;

        $context = $this->getPersistentParameter('context');

        if (!$context) {
            $context = $this->pool->getDefaultContext();
        }

        $formats = [];
        foreach ((array) $this->pool->getFormatNamesByContext($context) as $name => $options) {
            $formats[$name] = $name;
        }

        $contexts = [];
        foreach ((array) $this->pool->getContexts() as $contextItem => $format) {
            $contexts[$contextItem] = $contextItem;
        }

        $formMapper
            ->with('Détail')
                ->add('name')
                ->ifTrue($formats)
                ->add('defaultFormat', ChoiceType::class, ['choices' => $formats])
                ->ifEnd()
            ->end()
            ->with('Gallerie')
                ->add('galleryHasMedias', CollectionType::class, ['by_reference' => false], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                    'link_parameters' => ['context' => $context],
                    'admin_code' => 'sonata.media.admin.gallery_has_media',
                ])
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('context', null, [
                'show_filter' => false,
            ])
        ;
    }

}
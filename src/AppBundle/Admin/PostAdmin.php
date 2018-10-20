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
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Contenu', ['class' => 'col-md-8'])
                ->add('title', TextType::class, [
                    'label' => 'Titre'
                ])
                ->add('summary', TextareaType::class, [
                    'label' => 'Résumé'
                ])
                ->add('content', FormatterType::class, [
                    'format_field_options' => [
                        'choices' => [
                            'richhtml' => 'richhtml'
                        ],
                        'data' => 'richhtml',
                    ],
                    'source_field'         => 'rawContent',
                    'source_field_options' => [
                        'attr' => [
                            'class' => 'span10',
                            'rows' => 30
                        ],
                    ],
                    'format_field'         => 'contentFormatter',
                    'target_field'         => 'content',
                    'ckeditor_context'     => 'default',
                    'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
                ])
            ->end()
            ->with('Playlist', ['class' => 'col-md-4'])
                ->add('postHasSongs', CollectionType::class, [
                    'by_reference' => false,
                    'label' => 'Morceaux'
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                    'admin_code' => 'custom.media.admin.post_has_song'
                ])
            ->end()
            ->with('Gallerie', ['class' => 'col-md-8'])
                ->add('postHasMedias', CollectionType::class, [
                    'by_reference' => false,
                    'label' => 'Gallerie'
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                    'admin_code' => 'custom.media.admin.post_has_media'
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
            ->add('summary');
    }

    public function toString($object)
    {
        return $object instanceof Post
            ? $object->getTitle()
            : 'Fiche thématique'; // shown in the breadcrumb on the create view
    }
}

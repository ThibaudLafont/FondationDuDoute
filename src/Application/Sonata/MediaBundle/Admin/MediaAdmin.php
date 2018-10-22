<?php
namespace Application\Sonata\MediaBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\MediaBundle\Admin\BaseMediaAdmin;

class MediaAdmin extends BaseMediaAdmin
{

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
                'show_filter' => false
            ])
        ;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        // Get Media Type Filter
        $mediaType = $this->getRequest()->get('mediaType');

        $query->andWhere(
            $query->expr()->eq($query->getRootAliases()[0] . '.providerName', ':my_param')
        );

        // Audio medias
        if($mediaType === 'audio') {
            $query->setParameter('my_param', 'sonata.media.provider.audio');
        // Image media
        } elseif ($mediaType === 'image') {
            $query->setParameter('my_param', 'sonata.media.provider.custom.image');
        }

//        $query->orWhere(
//            $query->expr()->eq($query->getRootAliases()[0] . '.providerName', ':my_param2')
//        );
//        $query->setParameter('my_param', 'sonata.media.provider.custom.image');
//        $query->setParameter('my_param2', 'sonata.media.provider.custom.vimeo');

        return $query;
    }

}
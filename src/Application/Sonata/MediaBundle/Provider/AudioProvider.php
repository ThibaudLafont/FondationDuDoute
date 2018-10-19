<?php
namespace Application\Sonata\MediaBundle\Provider;

use Sonata\CoreBundle\Model\Metadata;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\FileProvider;

class AudioProvider extends FileProvider
{

    /**
     * {@inheritdoc}
     */
    public function getProviderMetadata()
    {
        return new Metadata($this->getName(), $this->getName().'.description', false, 'SonataMediaBundle', ['class' => 'glyphicon glyphicon-music']);
    }

    /**
     * {@inheritdoc}
     * In order to disable thumbnail creation
     */
    public function postPersist(MediaInterface $media)
    {
        if (null === $media->getBinaryContent()) {
            return;
        }

        $this->setFileContents($media);

        $media->resetBinaryContent();
    }

}
<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostHasSong
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 */
class PostHasMedia extends BaseHasMedia
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="postHasMedias", cascade={"persist"})
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param Post $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    public function isVideoMedia()
    {
        if($this->getMedia()->getProviderName() === 'sonata.media.provider.custom.image')
            return false;
        return true;
    }


    public function getUrlIfVideoMedia()
    {
        // Store parts of URL
        $media = $this->getMedia();
        $providerUrl = $media->getMetadataValue('provider_url');
        $urlAdd = '';
        $reference =  $media->getProviderReference();

        // Add url requirements if Dailymotion
        if(preg_match('%dailymotion%', $providerUrl)){
            $urlAdd = '/embed/video/';
        }

        // Concat & return
        return $providerUrl
            . $urlAdd
            . $reference;
    }

}

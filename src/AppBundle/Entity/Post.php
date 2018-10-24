<?php
namespace AppBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
*/
class Post
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
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     * @Assert\NotNull(message="Veuillez renseigner le titre")
     * @Assert\NotBlank(message="Veuillez renseigner le titre")
     */
    private $title;

    /**
     * @var Media
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\CoverImage", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $coverImage;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="string")
     * @Assert\NotNull(message="Veuillez renseigner un résumé")
     * @Assert\NotBlank(message="Veuillez renseigner un résumé")
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotNull(message="Veuillez renseigner un contenu")
     * @Assert\NotBlank(message="Veuillez renseigner un contenu")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="raw_content", type="text")
     */
    private $rawContent;

    /**
     * @var \Date
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PostHasSong", mappedBy="post", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $postHasSongs;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PostHasMedia", mappedBy="post", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $postHasMedias;

    /**
     * @var EventDispatcher
     */
    private $contentFormatter;

    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->postHasSongs = new ArrayCollection();
        $this->postHasMedias = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return Media
     */
    public function getCoverImage()
    {
        return $this->coverImage;
    }

    /**
     * @param Media $coverImage
     */
    public function setCoverImage($coverImage)
    {
        $this->coverImage = $coverImage;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return \Date
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \Date $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * @param string $rawContent
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;
    }

    /**
     * @return mixed
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * @param mixed $contentFormatter
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
    }

    /**
     * @return ArrayCollection
     */
    public function getPostHasSongs()
    {
        return $this->postHasSongs;
    }

    public function setPostHasSongs($postHasSongs)
    {
        // Avoid existant postHasSongs duplication
        $this->postHasSongs->clear();

        // Loop and assign Entities to this Book
        foreach($postHasSongs as $postHasSong){
            if($postHasSong instanceof PostHasSong){
                $this->addPostHasSong($postHasSong);
            }
        }
    }

    public function addPostHasSong(PostHasSong $postHasSong) {
        // Add BookHasMedia to array
        $this->postHasSongs->add($postHasSong);
        //Set this to bookHasMedia
        $postHasSong->setPost($this);
    }

    /**
     * @return ArrayCollection
     */
    public function getPostHasMedias()
    {
        return $this->postHasMedias;
    }

    public function setPostHasMedias($postHasMedias)
    {
        // Avoid existant postHasMedias duplication
        $this->postHasMedias->clear();

        // Loop and assign Entities to this Book
        foreach($postHasMedias as $postHasMedia){
            if($postHasMedia instanceof PostHasMedia){
                $this->addPostHasMedia($postHasMedia);
            }
        }
    }

    public function addPostHasMedia(PostHasMedia $postHasMedia) {
        // Add BookHasMedia to array
        $this->postHasMedias->add($postHasMedia);
        //Set this to bookHasMedia
        $postHasMedia->setPost($this);
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * @return bool
     * @Assert\IsTrue(message="Veuillez renseigner une image de couverture")
     */
    public function hasACoverImage()
    {
        return $this->getCoverImage()->getMedia() !== null;
    }

    public function getSongNbre()
    {
        return $this->getPostHasSongs()->count();
    }

    public function getShowUrl()
    {
        return '/post/' . $this->getId();
    }

    public function getImgNbre()
    {
        $imgNbre = 0;
        foreach($this->getPostHasMedias() as $phM) {
            $providerName = $phM->getMedia()->getProviderName();
            if($providerName === 'sonata.media.provider.custom.image') {
                $imgNbre ++;
            }
        }
        return $imgNbre;
    }

    public function getVideoNbre()
    {
        $videoNbre = 0;
        foreach($this->getPostHasMedias() as $phM) {
            $providerName = $phM->getMedia()->getProviderName();
            if(
                $providerName === 'sonata.media.provider.custom.youtube' ||
                $providerName === 'sonata.media.provider.custom.vimeo' ||
                $providerName === 'sonata.media.provider.custom.dailymotion'
            ) {
                $videoNbre ++;
            }
        }
        return $videoNbre;
    }

    public function getCreationDate()
    {
        return $this->getCreatedAt()->format('d/m/Y');
    }
}
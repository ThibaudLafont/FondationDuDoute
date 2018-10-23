<?php
namespace AppBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @ORM\Entity()
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
     */
    private $title;

    /**
     * @var Media
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\CoverImage", cascade={"persist"})
     */
    private $coverImage;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="string")
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="raw_content", type="text")
     */
    private $rawContent;
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
}
<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Book
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 */
class Book
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
     * @ORM\Column(name="author", type="string")
     */
    private $author;

    /**
     * @var \Date
     *
     * @ORM\Column(name="publish_at", type="date")
     */
    private $publishAt;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text")
     */
    private $summary;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BookHasMedia", mappedBy="book", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $bookHasMedias;

    /**
     * Pre Update method.
     */
    public function __construct()
    {
        $this->bookHasMedias = new ArrayCollection();
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
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return \Date
     */
    public function getPublishAt()
    {
        return $this->publishAt;
    }

    /**
     * @param Notice: Undefined index\DateTime $publishAt
     */
    public function setPublishAt($publishAt)
    {
        $this->publishAt = $publishAt;
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
     * @return ArrayCollection
     */
    public function getBookHasMedias()
    {
        return $this->bookHasMedias;
    }

    public function setBookHasMedias($bookHasMedias)
    {
        // Avoid existant bookHasMedias duplication
        $this->bookHasMedias->clear();

        // Loop and assign Entities to this Book
        foreach($bookHasMedias as $bookHasMedia){
            if($bookHasMedia instanceof BookHasMedia){
                $this->addBookHasMedia($bookHasMedia);
            }
        }
    }

    public function addBookHasMedia(BookHasMedia $bookHasMedia) {
        // Add BookHasMedia to array
        $this->bookHasMedias->add($bookHasMedia);
        //Set this to bookHasMedia
        $bookHasMedia->setBook($this);
    }

}
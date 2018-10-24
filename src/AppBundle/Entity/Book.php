<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(name="author", type="string")
     * @Assert\NotNull(message="Veuillez renseigner l'auteur")
     * @Assert\NotBlank(message="Veuillez renseigner l'auteur")
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
     * @Assert\NotNull(message="Veuillez renseigner un résumé")
     * @Assert\NotBlank(message="Veuillez renseigner un résumé")
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

    /**
     * @return bool
     * @Assert\IsTrue(message="Veuillez renseigner une image de couverture")
     */
    public function hasACoverImage()
    {
        return $this->getCoverImage()->getMedia() !== null;
    }

    /**
     * @return bool
     * @Assert\IsTrue(message="Veuillez ajouter au moins une page")
     */
    public function hasAtLeastOneBookHasMedia()
    {
        // If has more than one media
        if($this->getBookHasMedias()->count() > 1) {
            return true;
        // If one item, check if media was inquired
        } elseif($this->getBookHasMedias()->count() === 1) {
            return $this->getBookHasMedias()->get(0)->getMedia() !== null;
        // Else no media, return false
        } else {
            return false;
        }
    }

}
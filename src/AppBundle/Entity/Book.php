<?php
namespace AppBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Gallery;
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
     * @var string
     *
     * @ORM\Column(name="author", type="string")
     */
    private $author;

    /**
     * @var \Date
     *
     * @ORM\Column(name="publish_at", type="datetime")
     */
    private $publishAt;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text")
     */
    private $summary;

    /**
     * @var Gallery
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery", inversedBy="books")
     */
    private $gallery;

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
     * @param \Date $publishAt
     */
    public function setPublishAt(\Date $publishAt)
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
     * @return Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param Gallery $gallery
     */
    public function setGallery(Gallery $gallery)
    {
        $this->gallery = $gallery;
    }

}
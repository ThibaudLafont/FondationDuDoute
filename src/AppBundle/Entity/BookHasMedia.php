<?php
namespace AppBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BookHasMedia
 * @package Application\Sonata\MediaBundle\Entity
 *
 * @ORM\Entity()
 */
class BookHasMedia extends BaseHasMedia
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
     * @var Book
     *

     * @ORM\ManyToOne(targetEntity="Book", inversedBy="bookHasMedias", cascade={"persist"})
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     */
    private $book;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @param Book $book
     */
    public function setBook($book)
    {
        $this->book = $book;
    }

}
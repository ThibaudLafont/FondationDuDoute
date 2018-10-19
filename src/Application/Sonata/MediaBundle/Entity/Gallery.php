<?php

namespace Application\Sonata\MediaBundle\Entity;

use AppBundle\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;

/**
 * This file has been generated by the SonataEasyExtendsBundle.
 *
 * @link https://sonata-project.org/easy-extends
 *
 * References:
 * @link http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 */
class Gallery extends BaseGallery
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="gallery")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="Book", mappedBy="gallery")
     */
    private $books;

    public function __construct()
    {
        // Initialize array collections
        $this->posts = new ArrayCollection();
        $this->galleryHasMedias = new ArrayCollection();

        // Allow to disable fields in form
        $this->enabled = true;
        $this->context = "default";
    }

    /**
     * Get id.
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    public function addPost(Post $post)
    {
        $this->posts->add($post);
    }

    /**
     * @return mixed
     */
    public function getBooks()
    {
        return $this->books;
    }

    public function addBook(Book $book)
    {
        $this->books->add($book);
    }
}

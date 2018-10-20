<?php
namespace AppBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    private $rawContent;
    private $contentFormatter;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PostHasSong", mappedBy="post", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $postHasSongs;

    /**
     * Pre Update method.
     */
    public function __construct()
    {
        $this->postHasSongs = new ArrayCollection();
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
}
<?php
namespace AppBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Website
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 */
class Website
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
     * @var Media
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\CoverImage", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $coverImage;

    /**
     * @var string
     *
     * @ORM\Column(name="artist_name", type="string")
     * @Assert\NotNull(message="Veuillez renseigner le nom de l'artiste")
     * @Assert\NotBlank(message="Veuillez renseigner le nom de l'artiste")
     */
    private $artistName;

    /**
     * @var string
     *
     * @ORM\Column(name="website_url", type="string")
     * @Assert\NotNull(message="Veuillez renseigner l'url")
     * @Assert\NotBlank(message="Veuillez renseigner l'url")
     * @Assert\Url(message="Veuillez renseigner une URL valide")
     */
    private $websiteUrl;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getArtistName()
    {
        return $this->artistName;
    }

    /**
     * @param string $artistName
     */
    public function setArtistName($artistName)
    {
        $this->artistName = $artistName;
    }

    /**
     * @return string
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * @param string $websiteUrl
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;
    }

    /**
     * @return bool
     * @Assert\IsTrue(message="Veuillez renseigner une image de couverture")
     */
    public function hasACoverImage()
    {
        return $this->getCoverImage()->getMedia() !== null;
    }

}
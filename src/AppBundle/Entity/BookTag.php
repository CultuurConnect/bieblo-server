<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Keyword
 *
 * @ORM\Table(name="book_tag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookTagRepository")
 */
class BookTag
{
    /**
     * @var Book
     * @ORM\ManyToOne(targetEntity="Book")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     * @ORM\Id
     */
    private $book;

    /**
     * @var Tag
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * @ORM\Id
     */
    private $tag;

    /**
     * @var AgeGroup
     * @ORM\ManyToOne(targetEntity="AgeGroup")
     * @ORM\JoinColumn(name="age_group_id", referencedColumnName="id")
     * @ORM\Id
     */
    private $ageGroup;

    /**
     * @ORM\Column(type="boolean")
     */
    private $available;

    /**
     * @ORM\Column(name="subloc", type="string", length=255, nullable=true)
     */
    private $subloc;

    /**
     * @ORM\Column(name="shelfmark", type="string", length=255, nullable=true)
     */
    private $shelfmark;

    /**
     * Set book
     *
     * @param \AppBundle\Entity\Book $book
     *
     * @return BookTag
     */
    public function setBook(\AppBundle\Entity\Book $book)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return \AppBundle\Entity\Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return BookTag
     */
    public function setTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \AppBundle\Entity\Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set ageGroup
     *
     * @param \AppBundle\Entity\AgeGroup $ageGroup
     *
     * @return BookTag
     */
    public function setAgeGroup(\AppBundle\Entity\AgeGroup $ageGroup)
    {
        $this->ageGroup = $ageGroup;

        return $this;
    }

    /**
     * Get ageGroup
     *
     * @return \AppBundle\Entity\AgeGroup
     */
    public function getAgeGroup()
    {
        return $this->ageGroup;
    }

    /**
     * Set available
     *
     * @param $available
     *
     * @return BookTag
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return \bool
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set subloc
     *
     * @param string $subloc
     *
     * @return BookTag
     */
    public function setSubloc($subloc)
    {
        $this->subloc = $subloc;

        return $this;
    }

    /**
     * Get subloc
     *
     * @return string
     */
    public function getSubloc()
    {
        return $this->subloc;
    }

    /**
     * Set shelfmark
     *
     * @param string $shelfmark
     *
     * @return BookTag
     */
    public function setShelfmark($shelfmark)
    {
        $this->shelfmark = $shelfmark;

        return $this;
    }

    /**
     * Get shelfmark
     *
     * @return string
     */
    public function getShelfmark()
    {
        return $this->shelfmark;
    }
}

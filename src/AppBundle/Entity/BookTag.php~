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
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgeGroup
 *
 * @ORM\Table(name="age_groups")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AgeGroupRepository")
 */
class AgeGroup
{
    /**
     * Unique identifier
     *
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="query_String", type="string", length=255, unique=false)
     */
    protected $queryString;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return AgeGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * @param string $queryString
     *
     * @return AgeGroup
     */
    public function setQueryString($queryString)
    {
        $this->queryString = $queryString;

        return $this;
    }
}
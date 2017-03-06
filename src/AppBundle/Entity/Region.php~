<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Region
 *
 * @ORM\Table(name="region")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegionRepository")
 */
class Region implements \JsonSerializable
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=100, unique=true)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="Library", mappedBy="region")
     */
    private $libraries;

    /**
     * One Category has Many Categories.
     * @ORM\OneToMany(targetEntity="Region", mappedBy="parent")
     */
    private $children;

    /**
     * @var Region|null
     *
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * Region constructor.
     */
    public function __construct()
    {
        $this->libraries = new ArrayCollection();
        $this->children = new ArrayCollection();
    }


    /**
     * Set id
     *
     * @param string $id
     *
     * @return Region
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Region
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Region
     */
    public function setUrl($url)
    {
        $this->url = rtrim(ltrim(ltrim($url, 'https://'), 'http://'), '/');

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Add library
     *
     * @param \AppBundle\Entity\Library $library
     *
     * @return Region
     */
    public function addLibrary(\AppBundle\Entity\Library $library)
    {
        $this->libraries[] = $library;

        return $this;
    }

    /**
     * Remove library
     *
     * @param \AppBundle\Entity\Library $library
     */
    public function removeLibrary(\AppBundle\Entity\Library $library)
    {
        $this->libraries->removeElement($library);
    }

    /**
     * Get libraries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLibraries()
    {
        return $this->libraries;
    }

    /**
     * Set parent
     *
     * @param \AppBundle\Entity\Region $parent
     *
     * @return Region
     */
    public function setParent(\AppBundle\Entity\Region $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Region
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'url' => $this->getUrl(),
            'parent' => $this->getParent() instanceof Region
                ? $this->getParent()->getId()
                : null,
        ];
    }

    /**
     * Add child
     *
     * @param \AppBundle\Entity\Region $child
     *
     * @return Region
     */
    public function addChild(\AppBundle\Entity\Region $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AppBundle\Entity\Region $child
     */
    public function removeChild(\AppBundle\Entity\Region $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Region $region
     * @return bool
     */
    public function hasChanges(Region $region)
    {
        $changed = false;
        if ($region->getName() !== $this->getName()) {
            $changed = true;
            $this->setName($region->getName());
        }

        if ($region->getUrl() !== $this->getUrl()) {
            $changed = true;
            $this->setUrl($this->getUrl());
        }

        if ($region->getParent() || $this->getParent()) {
            if ($region->getParent() && !$this->getParent()) {
                $changed = true;
                $this->setParent($region->getParent());
            } elseif (!$region->getParent() && $this->getParent()) {
                $changed = true;
                $this->setParent();
            } elseif ($region->getParent()->getId() !== $this->getParent()->getId()) {
                $changed = true;
                $this->setParent($region->getParent());
            }
        }

        $currentChildren = array_map(function(Region $item){
            return $item->getId();
        }, $this->getChildren()->toArray());

        $newChildren = array_map(function(Region $item){
            return $item->getId();
        }, $region->getChildren()->toArray());


        if ($currentChildren != $newChildren) {
            $changed = true;
            $this->children = new ArrayCollection();
            foreach ($region->getChildren() as $child) {
                $this->addChild($child);
            }
        }

        return $changed;
    }
}

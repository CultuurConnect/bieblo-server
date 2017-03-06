<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Library\Address;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Library
 *
 * @ORM\Table(name="library")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LibraryRepository")
 */
class Library implements \JsonSerializable
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=191, unique=true)
     * @ORM\Id
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=11, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=10, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="impala", type="string", length=60, nullable=true, unique=false)
     */
    private $impala;

    /**
     * @var string
     *
     * @ORM\Column(name="bios", type="string", length=60, nullable=true, unique=false)
     */
    private $bios;

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="libraries")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Library\Address", mappedBy="library")
     * @var Address
     */
    private $address;

    /**
     * Set id
     *
     * @param string $id
     *
     * @return Library
     */
    public function setId($id)
    {
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
     * @return Library
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
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Library
     */
    public function setLatitude($latitude)
    {
        $this->latitude = strlen($latitude) ? number_format(floatval($latitude), 6) : null;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Library
     */
    public function setLongitude($longitude)
    {
        $this->longitude = strlen($longitude) ? number_format(floatval($longitude), 6) : null;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set impala
     *
     * @param string $impala
     *
     * @return Library
     */
    public function setImpala($impala)
    {
        $this->impala = $impala;

        return $this;
    }

    /**
     * Get impala
     *
     * @return string
     */
    public function getImpala()
    {
        return $this->impala;
    }

    /**
     * Set bios
     *
     * @param string $bios
     *
     * @return Library
     */
    public function setBios($bios)
    {
        $this->bios = $bios;

        return $this;
    }

    /**
     * Get bios
     *
     * @return string
     */
    public function getBios()
    {
        return $this->bios;
    }

    /**
     * Set region
     *
     * @param \AppBundle\Entity\Region $region
     *
     * @return Library
     */
    public function setRegion(\AppBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \AppBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set address
     *
     * @param \AppBundle\Entity\Library\Address $address
     *
     * @return Library
     */
    public function setAddress(\AppBundle\Entity\Library\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \AppBundle\Entity\Library\Address
     */
    public function getAddress()
    {
        return $this->address;
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
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
            'bios' => $this->getBios(),
            'impala' => $this->getImpala(),
            'region' => $this->getRegion() instanceof Region
                ? $this->getRegion()->getId()
                : null,
            'address' => $this->getAddress() instanceof Address
                ? $this->getAddress()->jsonSerialize()
                : null
        ];
    }
}

<?php

namespace AppBundle\Entity\Library;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Address
 *
 * @ORM\Table(name="library_address")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Library\AddressRepository")
 */
class Address implements \JsonSerializable
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

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
     * @ORM\Column(name="street", type="string", length=150, nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=20, nullable=true)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=150, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="community", type="string", length=150, nullable=true)
     */
    private $community;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=40, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=90, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=25, nullable=true)
     */
    private $postcode;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Library", inversedBy="address")
     * @ORM\JoinColumn(name="library_id", referencedColumnName="id")
     */
    private $library;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Address
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set community
     *
     * @param string $community
     *
     * @return Address
     */
    public function setCommunity($community)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community
     *
     * @return string
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Address
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Address
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     *
     * @return Address
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Address
     */
    public function setUrl($url)
    {
        $this->url = $url;

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
     * Set library
     *
     * @param \AppBundle\Entity\Library $library
     *
     * @return Address
     */
    public function setLibrary(\AppBundle\Entity\Library $library = null)
    {
        $this->library = $library;

        return $this;
    }

    /**
     * Get library
     *
     * @return \AppBundle\Entity\Library
     */
    public function getLibrary()
    {
        return $this->library;
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
            'street' => $this->getStreet(),
            'number' => $this->getNumber(),
            'city' => $this->getCity(),
            'community' => $this->getCommunity(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'postcode' => $this->getPostcode(),
            'url' => $this->getUrl(),
        ];
    }
}

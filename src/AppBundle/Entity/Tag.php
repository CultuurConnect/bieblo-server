<?php

namespace AppBundle\Entity;

class Tag
{
    /**
     * @var string
     */
    private $tag;


    /**
     * @var string
     *
     * @ORM\Column(name="query_String", type="string", length=255, unique=false)
     */
    protected $queryString;
}
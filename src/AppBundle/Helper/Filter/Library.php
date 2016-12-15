<?php

namespace AppBundle\Helper\Filter;

use AppBundle\Entity\Region as EntityRegion;
use AppBundle\Entity\Library as EntityLibrary;

class Library
{
    /**
     * @param array<EntityLibrary> $libraries
     * @param EntityRegion $region
     * @return array
     */
    static public function filterForRegion(array $libraries, EntityRegion $region)
    {
        return array_filter(
            $libraries,
            function(EntityLibrary $l) use ($region){
                return $l->getRegion()->getId() === $region->getId();
            }
        );
    }
}
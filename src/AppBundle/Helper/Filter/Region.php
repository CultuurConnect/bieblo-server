<?php

namespace AppBundle\Helper\Filter;

use AppBundle\Entity\Region as EntityRegion;
use AppBundle\Entity\Library as EntityLibrary;

class Region {

    /**
     * @param array<RegionEntity> $regions
     * @return array<RegionEntity>
     */
    static public function rootRegions(array $regions) {
        return array_filter($regions, function(EntityRegion $region){
           return $region->getParent() === null;
        });
    }

    /**
     * @param array<RegionEntity> $regions
     * @param $parentRegion $parentRegion
     * @return array<RegionEntity>
     */
    static public function childRegionsOfRegion(array $regions, EntityRegion $parentRegion) {
        return array_filter($regions, function (EntityRegion $region) use ($parentRegion){
            return $region->getParent() === $parentRegion;
        });
    }
}
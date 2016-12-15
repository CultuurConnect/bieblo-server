<?php

namespace AppBundle\Helper\Map;

use AppBundle\Entity\Region as EntityRegion;
use AppBundle\Helper\Map\Library as mapLibrary;
use AppBundle\Helper\Map\Region as mapRegion;
use AppBundle\Helper\Filter\Library as filterLibrary;
use AppBundle\Helper\Filter\Region as filterRegion;

class Region
{
    /**
     * @param array<EntityRegion> $regions
     * @return array
     */
    static public function serializeRegions(array $regions)
    {
        return array_values(
            array_map(
                function (EntityRegion $region)
                {
                    return $region->jsonSerialize();
                },
                $regions
            )
        );
    }

    /**
     * @param array<EntityRegion> $regions
     * @param array<EntityLibrary> $regions
     * @return array
     */
    static public function serializeRegionsWithLibraries(array $regions, array $libraries)
    {
        return array_values(
            array_map(
                function (EntityRegion $region) use ($libraries)
                {
                    $regionSerialized = $region->jsonSerialize();
                    $regionSerialized['libraries'] = mapLibrary::serializeLibraries(
                        filterLibrary::filterForRegion($libraries, $region)
                    );
                    return $regionSerialized;
                },
                $regions
            )
        );
    }

    static public function serializeRegionsWithLibrariesAsTree(array $regions, array $libraries)
    {
        return array_values(
            array_map(
                function(EntityRegion $region) use ($regions, $libraries)
                {
                    $item = $region->jsonSerialize();
                    $children = filterRegion::childRegionsOfRegion($regions, $region);
                    $item['children'] = mapRegion::serializeRegionsWithLibraries($children, $libraries);
                    return $item;
                },
                FilterRegion::rootRegions($regions)
            )
        );
    }
}
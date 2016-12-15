<?php

namespace AppBundle\Helper\Map;

use AppBundle\Entity\Library as EntityLibrary;

class Library
{
    /**
     * @param array $libraries
     * @return array
     */
    static public function serializeLibraries(array $libraries)
    {
        return array_values(
            array_map(
                function(EntityLibrary $library) {
                    return $library->jsonSerialize();
                },
                $libraries
            )
        );
    }
}
<?php

namespace AppBundle\Helper;

use AppBundle\Entity\Region;

class Path {
    /**
     * @param Region|null $region
     * @return string
     */
    static public function getRegionPath(Region $region=null)
    {
        $path = 'holdings/root';
        if ($region instanceof Region) {
            $path = 'holdings/' . strtolower(ltrim($region->getId(), '/root/bibnet'));
        }
        return $path;
    }

}
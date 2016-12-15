<?php

namespace AppBundle\Parser\XML;

/**
 * Class Region
 *
 * Parse a XML region to Region Entity
 *
 * @package AppBundle\Parser\XML
 */
class Region {

    /**
     * @param \DOMElement $DOMElement
     *
     * @return \AppBundle\Entity\Region
     */
    public static function parse(\DOMElement $DOMElement) {
        $region = new \AppBundle\Entity\Region();


        return $region;
    }




}
<?php

namespace AppBundle\Service\CultuurConnect\Fetch;

use AppBundle\Entity\Region;
use AppBundle\Helper\Path;
use AppBundle\Helper\XPath;

/**
 * Class Regions
 *
 * @package AppBundle\Service\CultuurConnect\Fetch
 */
class Regions extends AbstractFetch
{
    /**
     * @return array<Region>
     */
    public function fetchAll()
    {
        $xmlDocument = $this->getRegionXMLDocument();
        $regions = $this->fetchProvinces($xmlDocument);
        foreach ($regions as $region) {
            $regions = array_merge(
                $regions,
                $this->fetchProvinceRegions($region, $xmlDocument)
            );
        }
        return $regions;
    }

    /**
     * @param string|null $xmlDocument
     *
     * @return array <Region>
     */
    public function fetchProvinces($xmlDocument=null)
    {
        $xmlDocument = $this->getRegionXMLDocument($xmlDocument);
        return $this->getProvincesFromDocument($xmlDocument);
    }

    /**
     *
     * @param string|null $xmlDocument
     * @param Region $region
     *
     * @return array<Region>
     */
    public function fetchProvinceRegions(Region $region, $xmlDocument=null)
    {
        $xmlDocument = $this->getRegionXMLDocument($xmlDocument, $region);
        return $this->getRegionsForParentRegion($region, $xmlDocument);
    }

    /**
     * @param string $xmlDocument
     * @return array<Region>
     */
    protected function getProvincesFromDocument($xmlDocument)
    {
        $domElements = $this->filterDOMElements($xmlDocument, XPath::province());
        return $this->regionEntitiesFromDomElements($domElements);
    }

    /**
     * @param Region $provinceRegion
     * @param string $xmlDocument
     *
     * @return array<Region>
     */
    protected function getRegionsForParentRegion(Region $provinceRegion, $xmlDocument) {
        $domElements = $this->filterDOMElements($xmlDocument, XPath::provinceRegion($provinceRegion));
        return $this->regionEntitiesFromDomElements($domElements, $provinceRegion);
    }

    /**
     * @param array<DOMElement> $DOMElements
     * @param Region|null $parentRegion
     * @return array<Region>
     */
    protected function regionEntitiesFromDomElements(array $DOMElements, Region $parentRegion = null) {
        return array_map(
            function(\DOMElement $element) use ($parentRegion)
            {
                $regionId = $element->getAttribute('id');
                $region = $this->findOrCreateEntity($regionId);
                $region->setName($element->getAttribute('name'));
                $region->setUrl($element->getAttribute('url'));
                $region->setParent($parentRegion instanceof Region ? $parentRegion : null);
                return $region;
            },
            $DOMElements
        );
    }

    /**
     * @param string $regionId
     * @return Region|null|object
     */
    protected function findOrCreateEntity($regionId)
    {
        $region = $this->getEntityRepository()->find($regionId);
        if (!$region instanceof Region) {
            $region = new Region();
            $region->setId($regionId);
            $this->getEntityManager()->persist($region);
        }
        return $region;
    }
}
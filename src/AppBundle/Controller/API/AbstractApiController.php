<?php

namespace AppBundle\Controller\API;

use AppBundle\Entity\Region;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\Bieblo\Entity\KeywordEntityService;
use AppBundle\Service\Bieblo\Fetch\KeywordsFetchService;

/**
 * Class AbstractController
 *
 * @package AppBundle\Controller
 *
 * @Route(
 *     "/api",
 *     defaults={"_format": "json"}
 * )
 */
abstract class AbstractApiController extends Controller
{
    /**
     * @return \AppBundle\Service\Bieblo\Fetch\Libraries|object
     */
    protected function getServiceBiebloFetchRegions() {
        return $this->get('app.bieblo.fetch.regions');
    }

    /**
     * @return \AppBundle\Service\Bieblo\Fetch\Libraries|object
     */
    protected function getServiceBiebloFetchLibraries() {
        return $this->get('app.bieblo.fetch.libraries');
    }

    /**
     * @return \AppBundle\Service\Bieblo\Fetch\Keywords|object
     */
    protected function getServiceBiebloFetchKeywords() {
        return $this->get('app.bieblo.fetch.keywords');
    }

    /**
     * @return KeywordEntityService|object
     */
    protected function getKeywordEntityService() {
        return $this->get('app.cc.entity.keyword');
    }

    /**
     * @return \AppBundle\Service\CultuurConnect\Fetch\Books|object
     */
    protected function getServiceCultuurConnectFetchBooks() {
        return $this->get('app.cc.fetch.books');
    }

    /**
     * @return \AppBundle\Service\CultuurConnect\Fetch\Availability|object
     */
    protected function getServiceCultuurConnectFetchAvailability() {
        return $this->get('app.cc.fetch.availability');
    }

    /**
     * @param $regionId
     * @return \AppBundle\Entity\Region|null
     */
    protected function getRegionById ($regionId) {
        $regionId = '/' . $regionId;
        return $this->getServiceBiebloFetchRegions()->findById($regionId);
    }
}
<?php

namespace AppBundle\Controller\API;

use AppBundle\Entity\Region;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
abstract class ApiAbstractController extends Controller
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
     * @param $regionId
     * @return \AppBundle\Entity\Region|null
     */
    protected function getRegionById ($regionId) {
        $regionId = '/' . $regionId;
        return $this->getServiceBiebloFetchRegions()->findById($regionId);
    }
}
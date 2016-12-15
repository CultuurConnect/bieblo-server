<?php

namespace AppBundle\Controller\API;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use \AppBundle\Helper\Map\Region as mapRegion;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Region;

/**
 * Class RegionController
 *
 * @package AppBundle\Controller\API
 * @Route(
 *     "/api/regions",
 *     defaults={"_format": "json"}
 * )
 */
class RegionsController extends ApiAbstractController
{
    /**
     * Returns a flatten list of all the regions that are synced into the Bieblo server.
     *
     * @ApiDoc(
     *  resource=true,
     *  views={"API"},
     *  section="Regions",
     *  description="Returns a flatten list of all the regions that are synced."
     * )
     *
     * @Route("/flat")
     * @Route("/flat/{regionId}", requirements={"regionId"=".+"})
     * @Method("GET")
     * @param string $regionId Optional start regionId
     * @return JsonResponse
     */
    public function regionsFlatAction($regionId = null)
    {
        if ($regionId === null) {
            $regions = $this->getServiceBiebloFetchRegions()->findAll();
        } else {
            $region = $this->getRegionById($regionId);
            if (!$region instanceof Region) {
                throw $this->createNotFoundException('The region does not exist');
            } else {
                $regions = $this->getServiceBiebloFetchRegions()->findAllWithParent($region);
            }
        }

        return $this->json($regions);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  views={"API"},
     *  section="Regions",
     *  description="Returns a nested list of all the regions with their libraries that are synced.",
     * )
     * @Route("/tree")
     * @Route("/tree/{regionId}", requirements={"regionId"=".+"})
     * @Method("GET")
     * @param string $regionId When provided this regionId will be the start point of the tree.
     * @return JsonResponse
     */
    public function regionsTreeAction($regionId = null)
    {
        if ($regionId === null) {
            $regions = $this->getServiceBiebloFetchRegions()->findAll();
            $libraries = $this->getServiceBiebloFetchLibraries()->findAll();
        } else {
            $region = $this->getRegionById($regionId);
            if (!$region instanceof Region) {
                throw $this->createNotFoundException('The provided region does not exist');
            } else {
                $regions = $this->getServiceBiebloFetchRegions()->findAllWithParent($region);
                $libraries = $this->getServiceBiebloFetchLibraries()->findAllForRegion($region);
            }
        }

        $tree = mapRegion::serializeRegionsWithLibrariesAsTree($regions, $libraries);

        return $this->json($tree);
    }
}

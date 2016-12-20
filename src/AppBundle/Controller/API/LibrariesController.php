<?php

namespace AppBundle\Controller\API;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class LibraryController
 *
 * @package AppBundle\Controller\API
 *
 * @Route(
 *     "/api/libraries",
 *     defaults={"_format": "json"}
 * )
 */
class LibrariesController extends AbstractApiController
{

    /**
     * A flat list of all regions, optional filtered by a regionId.
     *
     * @ApiDoc(
     *  resource=true,
     *  views={"API"},
     *  section="Libraries",
     *  description="A flat list of all regions, optional filtered by a regionId."
     * )
     *
     * @Route("")
     * @Route("/{regionId}", requirements={"regionId"=".+"})
     * @Method("GET")
     * @param string $regionId Optional regionId for filtering.
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function librariesAction($regionId = null)
    {
        if ($regionId === null) {
            $libraries = $this->getServiceBiebloFetchLibraries()->findAll();
        } else {
            $region = $this->getRegionById($regionId);
            if (!$region instanceof \AppBundle\Entity\Region) {
                throw $this->createNotFoundException('The provided region does not exist');
            } else {
                $libraries = $this->getServiceBiebloFetchLibraries()->findAllForRegion($region);
            }
        }

        return $this->json($libraries);
    }
}
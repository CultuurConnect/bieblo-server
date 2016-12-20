<?php

namespace AppBundle\Controller\API;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class TagController
 *
 * @package AppBundle\Controller\API
 *
 * @Route(
 *     "/api/tag",
 *     defaults={"_format": "json"}
 * )
 */
class TagController extends AbstractApiController
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
     * @Route("/create")
     * @Method("POST")
     */
    public function createAction()
    {

    }
}
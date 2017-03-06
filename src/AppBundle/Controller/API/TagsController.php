<?php

namespace AppBundle\Controller\API;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class TagsController
 *
 * @package AppBundle\Controller\API
 *
 * @Route(
 *     "/api/tags",
 *     defaults={"_format": "json"}
 * )
 */
class TagsController extends AbstractApiController
{
    /**
     * Returns a list of all existing tags in the system
     *
     * @ApiDoc(
     *  resource=true,
     *  views={"API"},
     *  section="Tags",
     *  description="Returns a list of tags"
     * )
     *
     * @Route("/list")
     * @Method("GET")
     */
    public function listAction() {
        $tags = array(
            'test' => 'success'
        );
        return $this->json($tags);
    }

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
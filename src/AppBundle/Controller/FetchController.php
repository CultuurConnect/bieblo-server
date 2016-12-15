<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Region;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class FetchController extends Controller
{
    /**
     * Fetches all the regions from bibliotheek.be
     *
     *
     * @ApiDoc(
     *  resource=true,
     *  section="fetch",
     *  description="Fetches all the regions from bibliotheek.be",
     * )
     *
     * @Route("/fetch/regions", name="fetch_regions")
     */
    public function fetchRegionsAction(Request $request)
    {
        $regions = $this->get('app.cc.fetch.regions')->fetchAll();
        return $this->json($regions);
    }

    /**
     * @Route("/fetch/libraries", name="fetch_libraries")
     */
    public function fetchLibrariesAction(Request $request)
    {
        $regionId = $request->query->get('region');
        if (!$regionId) {
            throw new \Exception('No regionId provided!');
        }

        $region = $this->get('app.bieblo.fetch.regions')->getById($regionId);
        if (!$region instanceof Region) {
            $message = sprintf('Region with id \'%s\' not found!', $regionId);
            throw new \Exception($message);
        }

        $libraries = $this->get('app.cc.fetch.libraries')->fetchLibraries($region);
        return $this->json($libraries);
    }

    /**
     * @Route("/fetch/tags", name="fetch_tags")
     */
    public function fetchTags(Request $request)
    {
        $tag = $request->query->get('tag');

        $books = $this->get('app.cc.fetch.tags')->fetchForTag($tag);
    }
}

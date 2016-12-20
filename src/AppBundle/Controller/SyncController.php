<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SyncController extends Controller
{
    /**
     * @Route("/sync/regions", name="sync_regions")
     */
    public function syncRegionsAction(Request $request)
    {
        $result = $this->get('app.bieblo.sync.regions')->sync();
        return $this->json(array('success' => true, 'result' => $result));
    }

    /**
     * @Route("/sync/libraries", name="sync_libraries")
     */
    public function syncLibraries(Request $request)
    {
        $result = $this->get('app.bieblo.sync.libraries')->sync();
        return $this->json(array('success' => true, 'result' => $result));
    }


    /**
     * @Route("/sync/books", name="sync_libraries")
     */
    public function syncBooks(Request $request)
    {
        $keyword = $request->query->get('keyword');
        if (!$keyword) {
            throw new \Exception('no keyword');
        }

        $ageGroup = intval($request->query->get('ageGroup', 0));
        if ($ageGroup !== 1 && $ageGroup !== 2) {
            throw new \Exception('no valid ageGroup');
        }

        $result = $this->getSyncBooksService()->syncForKeyword($keyword, $ageGroup);
        return $this->json(array('success' => true, 'result' => $result));
    }

    /**
     * @return \AppBundle\Service\Bieblo\Sync\Books|object
     */
    protected function getSyncBooksService() {
        return $this->get('app.bieblo.sync.books');
    }
}

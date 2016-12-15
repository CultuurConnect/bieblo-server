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
}

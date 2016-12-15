<?php

namespace AppBundle\Service\Bieblo\Fetch;

use AppBundle\Entity\Region;

class Libraries extends AbstractFetch
{
    public function findAllForRegion(Region $region)
    {
        return $this->getEntityRepository()->findBy(array('region' => $region->getId()));
    }
}
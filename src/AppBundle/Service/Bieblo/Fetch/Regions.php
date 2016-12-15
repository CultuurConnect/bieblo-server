<?php

namespace AppBundle\Service\Bieblo\Fetch;

use AppBundle\Entity\Region;

class Regions extends AbstractFetch
{

    public function findAllRoot()
    {
        return $this->getEntityRepository()
                    ->createQueryBuilder('t')
                    ->where('t.parent IS NULL')
                    ->getQuery()
                    ->getResult();
    }

    public function findAllWithParent(Region $region = null)
    {
        if ($region === null) {

            return $this->getEntityRepository()
                ->createQueryBuilder('t')
                ->where('t.parent IS NOT NULL')
                ->getQuery()
                ->getResult();
        } else {
            return $this->getEntityRepository()
                ->findBy(array('parent' => $region->getId()));
        }
    }
}
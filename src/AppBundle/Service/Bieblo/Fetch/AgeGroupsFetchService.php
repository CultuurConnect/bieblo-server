<?php

namespace AppBundle\Service\Bieblo\Fetch;

class AgeGroupsFetchService extends AbstractBiebloFetchService
{

    public function fetchAgeGroups()
    {
        return $this->getEntityRepository()
                    ->createQueryBuilder('ag')
                    ->getQuery()
                    ->getResult();
    }
}
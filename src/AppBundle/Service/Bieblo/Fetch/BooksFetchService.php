<?php

namespace AppBundle\Service\Bieblo\Fetch;

class BooksFetchService extends AbstractBiebloFetchService
{
    /**
     * @param string $value
     * @return null|\AppBundle\Entity\Book|object
     */
    public function findByExternalId ($value) {
        return $this->getEntityRepository()->findOneBy(array('externalId' => $value));
    }
}
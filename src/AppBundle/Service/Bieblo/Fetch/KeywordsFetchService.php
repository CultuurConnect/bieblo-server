<?php

namespace AppBundle\Service\Bieblo\Fetch;

class KeywordsFetchService extends AbstractBiebloFetchService
{
    /**
     * @param string $value
     * @return null|\AppBundle\Entity\Keyword|object
     */
    public function findByValue ($value) {
        return $this->getEntityRepository()->findOneBy(array('value' => $value));
    }
}
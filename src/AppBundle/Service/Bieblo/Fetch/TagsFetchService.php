<?php

namespace AppBundle\Service\Bieblo\Fetch;

use AppBundle\Entity\Tag;

class TagsFetchService extends AbstractBiebloFetchService
{

    /**
     * @param $tagId
     * @return null|object|Tag
     */
    public function fetchTagByID($tagId)
    {
        return $this->getEntityRepository()->find($tagId);
    }
}
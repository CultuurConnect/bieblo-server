<?php

namespace AppBundle\Service\Bieblo\Entity;

use AppBundle\Service\Bieblo\AbstractBiebloService;
use AppBundle\Entity\Keyword;

/**
 * Class KeywordEntityService
 * @package AppBundle\Service\Bieblo\Entity
 */
class KeywordEntityService extends AbstractBiebloService
{
    /**
     * @param Keyword $keyword
     *
     * @return Keyword
     */
    public function save(Keyword $keyword) {
        $em = $this->getEntityManager();
        $em->persist($keyword);
        $em->flush();
        return $keyword;
    }
}
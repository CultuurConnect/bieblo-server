<?php
namespace AppBundle\Service\Bieblo\Fetch;

use AppBundle\Service\Bieblo\AbstractBiebloService;

abstract class AbstractBiebloFetchService extends AbstractBiebloService
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getEntityRepository()->findAll();
    }

    /**
     * @param $id
     * @return null|object
     */
    public function findById($id)
    {
        return $this->getEntityRepository()->find($id);
    }

}
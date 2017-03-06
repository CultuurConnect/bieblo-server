<?php

namespace AppBundle\Service\Bieblo\Fetch;

use Doctrine\ORM\Tools\Pagination\Paginator;


class BooksFetchService extends AbstractBiebloFetchService
{
    /**
     * @param string $value
     * @return null|\AppBundle\Entity\Book|object
     */
    public function findByExternalId ($value) {
        return $this->getEntityRepository()->findOneBy(array('externalId' => $value));
    }

    public function getNumBooks () {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(b.id)');
        $qb->from('AppBundle:Book','b');
        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param $amount
     * @param $batch
     * @return array
     */
    public function fetchBatch($amount, $batch) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b');
        $qb->from('AppBundle:Book', 'b');
        $qb->setFirstResult(($amount * ($batch + 1)) - $amount);
        $qb->setMaxResults($amount);
        return $qb->getQuery()->getResult();
    }


}
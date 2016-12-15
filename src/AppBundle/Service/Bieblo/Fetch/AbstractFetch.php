<?php
namespace AppBundle\Service\Bieblo\Fetch;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class AbstractFetch
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $entityRepository;

    /**
     * Regions constructor.
     * @param EntityManager $entityManager
     * @param string $repositoryName
     */
    public function __construct(EntityManager $entityManager, $repositoryName)
    {
        $this->setEntityManager($entityManager);
        $this->setEntityRepositoryByName($repositoryName);
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityRepository
     */
    public function getEntityRepository()
    {
        return $this->entityRepository;
    }

    /**
     * @param EntityRepository $entityRepository
     */
    public function setEntityRepository($entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    /**
     * @param string $repositoryName
     */
    public function setEntityRepositoryByName($repositoryName)
    {
        $this->setEntityRepository($this->getEntityManager()->getRepository($repositoryName));
    }

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
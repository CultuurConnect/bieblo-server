<?php

namespace AppBundle\Service\CultuurConnect\Fetch;

use AppBundle\Entity\Region;
use AppBundle\Helper\Path;
use AppBundle\Service\CultuurConnect\Server;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractFetch
{
    /**
     * @var Server
     */
    private $server;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $entityRepository;

    /**
     * LibraryApi constructor.
     * @param EntityManager $entityManager
     * @param Server $server
     * @param string $entityName
     */
    public function __construct(Server $server, EntityManager $entityManager, $entityName)
    {
        $this->setServer($server);
        $this->setEntityManager($entityManager);
        $this->setEntityRepositoryByEntityName($entityName);
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
    public function setEntityManager(EntityManager $entityManager)
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
    public function setEntityRepository(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    /**
     * @param string $entityName
     */
    public function setEntityRepositoryByEntityName($entityName)
    {
        $this->setEntityRepository($this->getEntityManager()->getRepository($entityName));
    }

    /**
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param Server $server
     */
    public function setServer($server)
    {
        $this->server = $server;
    }

    /**
     * @param string $path
     * @param array|null $params
     *
     * @return string
     */
    protected function getXMLDocument($path, array $params=[])
    {
        return $this->getServer()->get($path, $params);
    }

    /**
     * @param string $xmlContent
     * @param string $filterXPath
     *
     * @return array<DOMElement>
     */
    protected function filterDOMElements($xmlContent, $filterXPath)
    {
        $crawler = new Crawler();
        $crawler->addXmlContent($xmlContent);
        return $crawler->filterXPath($filterXPath)->getIterator()->getArrayCopy();
    }

    /**
     * @param Region|null $region
     * @param string $xmlDocument
     *
     * @return string
     */
    protected function getRegionXMLDocument($xmlDocument=null, Region $region=null)
    {
        return $xmlDocument ? $xmlDocument : $this->getXMLDocument(Path::getRegionPath($region));
    }
}
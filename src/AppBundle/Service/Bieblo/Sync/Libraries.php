<?php

namespace AppBundle\Service\Bieblo\Sync;

use AppBundle\Entity\Library;
use AppBundle\Entity\Region;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;
use AppBundle\Service\Bieblo\Fetch\Regions as fetchRegions;
use AppBundle\Service\CultuurConnect\Fetch\Libraries as fetchLibraries;

class Libraries {
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var fetchLibraries
     */
    private $fetchRegions;
    /**
     * @var fetchLibraries
     */
    private $fetchLibraries;

    /**
     * Regions constructor.
     * @param EntityManager $entityManager
     * @param Logger $logger
     * @param $fetchRegions $fetchRegions
     * @param fetchLibraries $fetchLibraries
     */
    public function __construct(EntityManager $entityManager, Logger $logger, fetchRegions $fetchRegions, fetchLibraries $fetchLibraries)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->fetchRegions = $fetchRegions;
        $this->fetchLibraries = $fetchLibraries;
    }


    public function sync() {
        $regions = $this->fetchRegions->findAll();
        $results = array_map(function(Region $region) {
            return [$region->getId() => $this->syncForRegion($region)];
        }, $regions);
        return $results;
    }

    /**
     * @param Region $region
     *
     * @return array
     */
    public function syncForRegion(Region $region) {

        $libraries = $this->fetchLibraries->fetchLibraries($region);
        $uow = $this->entityManager->getUnitOfWork();

        $result = [
            'count' => 0,
            'updated' => [],
            'created' => [],
        ];

        /** @var Library $library */
        foreach ($libraries as $library) {
            $result['count']++;
            $uow->computeChangeSets();
            $changes = $uow->getEntityChangeSet($library);
            if (count($changes)) {
                $result['updated'][] = $library->getId();
                $this->writeLogUpdated($library, $changes);
            }
            if (!$library->getCreatedAt() instanceof \DateTime) {
                $result['created'][] = $library->getId();
                $this->writeLogCreated($library);
            }
        }

        $this->entityManager->flush();

        return $result;
    }

    /**
     * @param Library $library
     * @param array $changes
     */
    protected function writeLogUpdated(Library $library, array $changes)
    {
        $fields = join('; ', array_keys($changes));
        $this->writeLog($library, 'UPDATED', $fields);
    }

    /**
     * @param Library $library
     */
    protected function writeLogCreated(Library $library)
    {
        $this->writeLog($library, 'CREATED');
    }

    /**
     * @param Library $library
     * @param string $action
     * @param string|null $msg
     */
    protected function writeLog(Library $library, $action, $msg = null)
    {
        $msg = 'LIBRARY {ACTION} {LIBRARY}' . $msg ? ' ' . $msg : '';
        $context = array(
            'ACTION' => $action,
            'LIBRARY' => $library->getId(),
        );
        $this->logger->addInfo($msg, $context);
    }
}
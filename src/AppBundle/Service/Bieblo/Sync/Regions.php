<?php

namespace AppBundle\Service\Bieblo\Sync;

use AppBundle\Entity\Region;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;
use AppBundle\Service\CultuurConnect\Fetch\Regions as ServiceCultuurConnectFetchRegions;

class Regions {
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var ServiceCultuurConnectFetchRegions
     */
    private $serviceCultuurConnectRegions;

    /**
     * Regions constructor.
     * @param EntityManager $entityManager
     * @param Logger $logger
     * @param ServiceCultuurConnectFetchRegions $ccRegionsService
     */
    public function __construct(EntityManager $entityManager, Logger $logger, ServiceCultuurConnectFetchRegions $ccRegionsService)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->serviceCultuurConnectRegions = $ccRegionsService;
    }

    /**
     * @return array
     */
    public function sync() {

        $regions = $this->serviceCultuurConnectRegions->fetchAll();
        $uow = $this->entityManager->getUnitOfWork();

        $result = [
            'count' => 0,
            'updated' => [],
            'created' => [],
        ];

        /** @var Region $region */
        foreach ($regions as $region) {
            $result['count']++;
            $uow->computeChangeSets();
            $changes = $uow->getEntityChangeSet($region);
            if (count($changes)) {
                $result['updated'][] = $region->getId();
                $this->writeLogUpdated($region, $changes);
            }
            if (!$region->getCreatedAt() instanceof \DateTime) {
                $result['created'][] = $region->getId();
                $this->writeLogCreated($region);
            }
        }

        $this->entityManager->flush();

        return $result;
    }

    /**
     * @param Region $region
     * @param array $changes
     */
    protected function writeLogUpdated(Region $region, array $changes)
    {
        $fields = join('; ', array_keys($changes));
        $this->writeLog($region, 'UPDATED', $fields);
    }

    /**
     * @param Region $region
     */
    protected function writeLogCreated(Region $region)
    {
        $this->writeLog($region, 'CREATED');
    }

    /**
     * @param Region $region
     * @param string $action
     * @param string|null $msg
     */
    protected function writeLog(Region $region, $action, $msg = null)
    {
        $msg = 'REGION {ACTION} {REGION}' . $msg ? ' ' . $msg : '';
        $context = array(
            'ACTION' => $action,
            'REGION' => $region->getId(),
        );
        $this->logger->addInfo($msg, $context);
    }
}
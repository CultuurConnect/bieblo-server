<?php

namespace AppBundle\Service\CultuurConnect\Fetch;

use AppBundle\Entity\Library;
use AppBundle\Entity\Region;
use AppBundle\Helper\Path;
use AppBundle\Helper\XPath;
use AppBundle\Service\CultuurConnect\Server;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class Libraries extends AbstractFetch
{
    /**
     * @var Region
     */
    private $region;

    /**
     * @var EntityRepository
     */
    private $repositoryLibraryAddress;

    /**
     * Libraries constructor.
     * @param Server $server
     * @param EntityManager $entityManager
     * @param string $entityName
     */
    public function __construct(Server $server, EntityManager $entityManager, $entityName)
    {
        parent::__construct($server, $entityManager, $entityName);
        $this->repositoryLibraryAddress = $this->getEntityManager()->getRepository('AppBundle:Library\Address');
    }

    /**
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param Region $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @param Region $region
     *
     * @return array<Library>
     */
    public function fetchLibraries(Region $region)
    {
        $xmlDocument = self::getXMLDocument(Path::getRegionPath($region));
        $domElements = $this->filterDOMElements($xmlDocument, XPath::library());
        $this->setRegion($region);
        return array_map([$this, 'parseLibrary'], $domElements);
    }

    /**
     * @param \DOMElement $element
     * @return Library
     */
    function parseLibrary(\DOMElement $element) {
        $repository = $this->getEntityRepository();

        $id = $element->getAttribute('id');

        $entity = $repository->find($id);
        if (!$entity instanceof Library) {
            $entity = new Library();
            $entity->setId($id);
            $this->getEntityManager()->persist($entity);
        }

        $entity->setName($element->getAttribute('name'));
        $entity->setLatitude($element->getAttribute('latitude'));
        $entity->setLongitude($element->getAttribute('longitude'));
        $entity->setBios($element->getAttribute('bios'));
        $entity->setImpala($element->getAttribute('impala'));

        $entity->setRegion($this->getRegion());

        $entityAddress = $this->parseLibraryAddress($element, $entity);
        $entity->setAddress($entityAddress);

        return $entity;
    }

    /**
     * @param \DOMElement $element
     * @param Library $library
     * @return Library\Address
     */
    function parseLibraryAddress(\DOMElement $element, Library $library)
    {
        // Address
        $entityAddress = $this->repositoryLibraryAddress->findOneBy(array(
            'library' => $library->getId(),
        ));



        if (!$entityAddress instanceof Library\Address) {
            $entityAddress = new Library\Address();
            $entityAddress->setLibrary($library);
            $this->getEntityManager()->persist($entityAddress);
        }

        $library->setAddress($entityAddress);

        $addressElement = $element->getElementsByTagName('address')->item(0);

        if ($addressElement instanceof \DOMElement){
            $addressFields = ['street', 'number', 'city', 'community', 'phone', 'email', 'postcode', 'url'];
            /** @var \DOMElement $node */
            foreach ($addressElement->childNodes as $node) {
                $nodeName = $node->nodeName;
                if (in_array($nodeName, $addressFields)) {
                    $setter = 'set' . ucfirst($nodeName);
                    $entityAddress->$setter($node->nodeValue);
                }
            }
        }

        return $entityAddress;
    }

    /**
     * @param Region $region
     * @return string
     */
    static function getLocation(Region $region)
    {
        $regionIdParts = array_slice(explode('/', $region->getId()), -2);
        return sprintf('holdings/%s', join('/', $regionIdParts));
    }
}
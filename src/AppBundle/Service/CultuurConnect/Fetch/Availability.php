<?php

namespace AppBundle\Service\CultuurConnect\Fetch;

use AppBundle\Entity\Book;
use AppBundle\Helper\XPath;
//use AppBundle\Service\CultuurConnect\Server;
//use Doctrine\ORM\EntityManager;
//use Doctrine\ORM\EntityRepository;

class Availability extends AbstractFetch
{

    public function fetchAvailability(Book $book) {

        $id = $book->getExternalId();

        $xmlDocument = self::getXMLDocument('availability',array(
            'id' => $id
        ));

        $hoofdBilbliotheek = self::filterDOMElements($xmlDocument, XPath::location('/root/bibnet/West-Vlaanderen/Zedelgem/Hoofdbibliotheek'));

        if (count($hoofdBilbliotheek)) {
            $hoofdBilbliotheek = $hoofdBilbliotheek[0];
            if ($hoofdBilbliotheek instanceof \DOMElement) {
                $items = $hoofdBilbliotheek->getElementsByTagName('item');
                /** @var \DOMElement $item */
                foreach ($items as $item) {
                    if ($item->getAttribute('available') === 'true') {
                        $book->setAvailable(true);

                        $sublocEl = $item->getElementsByTagName('subloc')->item(0);
                        $subloc = $sublocEl ? $sublocEl->nodeValue : null;
                        $book->setSubloc($subloc);

                        $shelfmarkEl = $item->getElementsByTagName('shelfmark')->item(0);
                        $shelfmark = $shelfmarkEl ? $shelfmarkEl->nodeValue : null;
                        $book->setShelfmark($shelfmark);
                        break;
                    }
                }
            }
        }

        return $book;
    }
}

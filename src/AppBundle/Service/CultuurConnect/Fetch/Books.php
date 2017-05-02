<?php

namespace AppBundle\Service\CultuurConnect\Fetch;

use AppBundle\Entity\Book;
use AppBundle\Helper\XPath;
use AppBundle\Service\CultuurConnect\Server;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class Books extends AbstractFetch
{

    protected function fetchBooksPage($keyword, $ageGroup, $page=1)
    {
        switch ($ageGroup) {
            case 1:
                $doelGroep = 'AND (doelgroep:"vanaf 6-8 jaar" NOT genre:"eerste leesboekjes")';
                break;
            case 2 :
                $doelGroep = 'AND (doelgroep:"vanaf 9-11 jaar")';
                break;
            default:
                $doelGroep = '';
        }

        $notArchive = 'AND (NOT pbs-subloc:%22gent/hoofdbibliotheek|JM*%22)';

        $q = sprintf('%s %s %s', $keyword, $notArchive, $doelGroep);

        $q .= 'x';

        $xmlDocument = self::getXMLDocument('search',array(
            'q' => $q,
            'page' => $page
        ));

        $domElements = $this->filterDOMElements($xmlDocument, XPath::book());

        $countElement = $this->filterDOMElements($xmlDocument, XPath::count())[0];
        $count = $countElement instanceof \DOMElement ? intval($countElement->nodeValue) : 0;

        $pageElement = $this->filterDOMElements($xmlDocument, XPath::page())[0];
        $page = $pageElement instanceof \DOMElement ? intval($pageElement->nodeValue) : 0;

        $books = array_map([$this, 'parseBook'], $domElements);

        return array(
            'count' => $count,
            'page' => $page,
            'books' => $books,
        );
    }

    /**
     * @return array<Book>
     */
    public function fetchBooks($keyword, $ageGroup, $scrapeAll = true)
    {
        $books = array();

        $hasNextPage = true;
        $page = 1;

        while ($hasNextPage) {
            $result = $this->fetchBooksPage($keyword, $ageGroup, $page);
            $books = array_merge($books, $result['books']);
            $hasNextPage = $scrapeAll ? ceil(($result['count'] / 20)) >= $page + 1 : false;
            $page++;
        }

        return $books;
    }


    public function fetchRandomBooks($keyword, $ageGroup, $maxResults=10)
    {

        $firstRequest = $this->fetchBooksPage($keyword, $ageGroup);

        $books = $firstRequest['books'];
        shuffle($books);

        $maxPages = intval(ceil($firstRequest['count'] / 20));

        if ($maxPages > 1) {
            $randomPage = mt_rand(2, $maxPages);
            $secondRequest = $this->fetchBooksPage($keyword, $ageGroup, $randomPage);
            $books = array_merge($books, $secondRequest['books']);
        }

        // Temp cover filter on books
        $books = array_filter($books, function($book) {
            /** @var Book $book */
            return strlen($book->getCover());
        });

        return $books;
    }

    /**
     * @param \DOMElement $element
     * @return Book
     */
    function parseBook(\DOMElement $element) {

        $idElement = $element->getElementsByTagName('id')->item(0);
        $id = $idElement ? $idElement->nodeValue : null;

        $entity = $this->getEntityRepository()->findOneBy(array('externalId' => $id));

        if (!$entity) {
            $entity = new Book();
            $entity->setExternalId($id);
            $entity->setAvailable(false);
        }

        $titleElement = $element->getElementsByTagName('short-title')->item(0);
        $title = $titleElement ? $titleElement->nodeValue : '';

        $coverElement = $element->getElementsByTagName('coverimage')->item(0);
        $cover = $coverElement ? $coverElement->getElementsByTagName('url')->item(0)->nodeValue : '';

        $authorElement = $element->getElementsByTagName('main-author')->item(0);
        $author = $authorElement ? $authorElement->nodeValue : null;

        $summaryElement = $element->getElementsByTagName('summary')->item(0);
        $summary = $summaryElement ? $summaryElement->nodeValue : null;

        $entity->setTitle($title);
        $entity->setAuthor($author);
        $entity->setCover($cover);
        $entity->setSummary($summary);

        return $entity;
    }
}
<?php

namespace AppBundle\Controller\API;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class BooksController
 *
 * @package AppBundle\Controller\API
 *
 * @Route(
 *     "/api/books",
 *     defaults={"_format": "json"}
 * )
 */
class BooksController extends AbstractApiController
{
    /**
     * Get a flat list of books by given categories
     *
     * @ApiDoc(
     *  resource=true,
     *  views={"API"},
     *  section="Books",
     *  description="Get a flat list of books by given categories."
     * )
     *
     * @Route("")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function booksAction(Request $request)
    {
        $ageGroup = $request->get('ageGroup');
        $likes = $request->get('likes', array());

        shuffle($likes);

        $service = $this->getServiceCultuurConnectFetchBooks();

        $themes = [
            1 => [
                '(genre:"Humor")',
            ],
            2 => [
                '(genre:"Fantasy")', 'fantaseren' , 'heksen', 'prinsen en prinsessen', 'toveren', 'draken', 'griezels',
                'zeerovers', 'fantasievriendjes',
            ],
            3 => [
                '(genre:"Detectieve")', 'diefstallen', 'spioneren', 'mysteries', 'geheimen', 'misdaad',
                'gijzelingen en ontvoeringen', 'detectives',
            ],
            4 => [
                'voetbal', 'sport', 'autosport', 'zwemmen', 'bergsport', 'wedstrijden', 'hockey',
                'winnen-verliezen', 'skateboarden', 'snowboarden', 'motorsport', 'basketbal',
            ],
            5 => [
                'vriendschap met dieren', 'honden', 'katten', 'paarden',
            ]
        ];


        $keywords = [];

        foreach ($likes as $theme) {
            $newKeywords = $themes[$theme];
            shuffle($newKeywords);
            $keywords = array_merge($keywords, $newKeywords);
        }

        shuffle($keywords);

        $temp = [];
        $max = count($keywords);
        for ($i=0; $i <= 2 && $i <= $max; $i++) {
            $temp[] = array_pop($keywords);
        }

        $keywords = $temp;


        $books = [];
        foreach ($keywords as $keyword) {
            $books = array_merge($books, $service->fetchRandomBooks($keyword, $ageGroup));
            if (count($books)>50) {
                break;
            }
        }

        shuffle($books);

        // Check availability

        $availableBooks = [];

        while (count($books) && count($availableBooks) <= 16) {
            $book = array_pop($books);
            $book = $this->getServiceCultuurConnectFetchAvailability()->fetchAvailability($book);
            if ($book->isAvailable()) {
                $availableBooks[] = $book;
            }
        }

        return $this->json($availableBooks);
    }
}
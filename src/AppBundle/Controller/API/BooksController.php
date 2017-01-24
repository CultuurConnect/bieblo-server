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

        {id: 1, cls: 'new', img: '/swipe/Humor.jpg', label: 'Humor'},
        {id: 2, cls: 'new', img: '/swipe/Magie.jpg', label: 'Magie'},
        {id: 3, cls: 'new', img: '/swipe/Detectieve.jpg', label: 'Detectieve'},
        {id: 4, cls: 'new', img: '/swipe/Sport.jpg', label: 'Sport'},
        {id: 5, cls: 'new', img: '/swipe/Dieren.jpg', label: 'Dieren'},
        {id: 6, cls: 'new', img: '/swipe/AndereCulturen.jpg', label: 'Andere Culturen'},
        {id: 7, cls: 'new', img: '/swipe/Liefde.jpg', label: 'Liefde'},
        {id: 8, cls: 'new', img: '/swipe/OorlogHistorisch.jpg', label: 'Oorlog Historisch'},
        {id: 9, cls: 'new', img: '/swipe/Prijsboeken.jpg', label: 'Prijsboeken'},
        {id: 10, cls: 'new', img: '/swipe/Vriendschap.jpg', label: 'Vriendschap'},

        $themes = [
            1 => [
                '(genre:humor OR subject:lachen)',
                '(genre:humor OR subject:lachen) AND subject:schoolleven',
                '(genre:humor OR subject:lachen) AND subject:heksen',
                '(genre:humor OR subject:lachen) AND subject:chicklit',
                '(genre:humor OR subject:lachen) AND subject:magie',
                '(genre:humor OR subject:lachen) AND subject:vriendschap',
                '(genre:humor OR subject:lachen) AND subject:"anders zijn"',
                '(genre:humor OR subject:lachen) AND subject:"verliefd zijn"',
                '(genre:humor OR subject:lachen) AND subject:grootouders',
                '(genre:humor OR subject:lachen) AND subject:gezin',
                '(genre:humor OR subject:lachen) AND subject:helden',
                '(genre:humor OR subject:lachen) AND subject:"broers en zussen"',
                '(genre:humor OR subject:lachen) AND subject:spoken',
                '(genre:humor OR subject:lachen) AND subject:vakantie',
            ],
            2 => [
                '(genre:fantasieverhalen)',
                '(subject:fantaseren)' ,
                '(subject:heksen)',
                '(subject:"prinsen en prinsessen")',
                '(subject:toveren)',
                '(subject:draken)',
                '(subject:griezels)',
                '(subject:zeerovers)',
                '(subject:fantasievriendjes)',
            ],
            3 => [
                '(genre:"detectives")', '(genre:"avonturenverhalen")', '(genre:"griezelverhalen")',
                '(subject:diefstallen)', '(subject:spioneren)', '(subject:mysteries)',
                '(subject:geheimen)', '(subject:misdaad)', '(subject:”gijzelingen en ontvoeringen”)',
                '(subject:detectives)',
            ],
            4 => [
                '(genre:sportverhalen)',
                '(subject:voetbal)',
                '(subject:sport)',
                '(subject:autosport',
                '(subject:zwemmen)',
                '(subject:bergsport)',
                '(subject:wedstrijden)',
                '(subject:jockey)',
                '(subject:"winnen verliezen")',
                '(subject:skateboarden)',
                '(subject:snowboarden)',
                '(subject:motorsport)',
                '(subject:basketbal)',
            ],
            5 => [
                '(subject:"vriendschap met dieren ")', '(subject:dieren)', '(subject:honden)', '(subject:katten)',
                '(subject:paarden)', '(subject:dierenbescherming)', '(subject:dierenartsen)', '(subject:boerderijen)',
                '(subject:huisdieren)',
            ],
            6 => [
              '(subject:”andere culturen”)', '(subject:vluchtelingen)', '(subject:volken)',
              '(subject:indianen)', '(subject:”multiculturele samenleving”)',
            ],
            7 => [
              '(genre:liefdesverhalen)',
              'subject:liefde',
              'subject:vriendschap',
              'subject:"verliefd zijn"',
              'subject:"eenzaam zijn"',
              'subject:"afscheid nemen"',
              'subject:puberteit',
              'subject:seksualiteit',
            ],
            8 => [
              'genre:”historische verhalen”',
              'genre:oorlogsverhalen',
              'subject:middeleeuwen',
              'subject:ridders',
              'subject:oertijd',
              'subject:kinderarbeid',
              'subject:geschiedenis',
              'subject:"16de, 17de, 20ste eeuw"',
              'subject:tijdrijzen',
              'subject:"romeinse rijk"',
              'subject:overleven',
            ],
            9 => [
              'awards:boekenleeuw',
              'awards:boekenpauw',
              'awards:"zilveren griffel"',
              'awards:"zilveren penseel"',
              'awards:"gouden penseel"',
              'awards:"gouden uil"',
              'awards:"wouterse pieterse prijs"',
              'awards:KJV',
              'awards:"nederlands kinderjury"',
            ],
            10 => [
                'subject:vriendschap',
                'subject:"vriendschap met dieren"',
                'subject:"anders zijn"',
                'subject:schoolleven',
                'subject:geheimen',
                'subject:pesten',
                'subject:"jaloers zijn"',
                'subject:grootouders',
                'subject:gezin',
            ],
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

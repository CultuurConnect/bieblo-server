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
        $dislikes = $request->get('dislikes', array());
        $likes = $request->get('likes', array());

        $books = $this->getServiceBiebloFetchBookTags()->getRandomBooks($likes, $ageGroup);

        shuffle($books);

        $availableBooks = [];

        try {
            while (count($books) && count($availableBooks) <= 8) {
                $bookTag = array_pop($books);
                $book = $this->getServiceBiebloFetchBooks()->findById($bookTag['book_id']);
                $book = $this->getServiceCultuurConnectFetchAvailability()->fetchAvailability($book);
                if ($book->isAvailable()) {
                    $availableBooks[] = $book;
                }
            }
        } catch (\Exception $e) {
            return $this->json(array(
                'error'=> $e->getMessage()
            ));
        }


        return $this->json($availableBooks);
    }
}

<?php

namespace AppBundle\Service\Bieblo\Fetch;

use AppBundle\Entity\AgeGroup;
use AppBundle\Entity\Book;
use AppBundle\Entity\Tag;

class BookTagsFetchService extends AbstractBiebloFetchService
{

    /**
     * @param Book $book
     * @param Tag $tag
     * @param AgeGroup $ageGroup
     * @return null|object
     */
    public function fetchBookTag($book, $tag, $ageGroup) {
        return $this->getEntityRepository()->find(array(
            'book'=> $book->getId(),
            'tag' => $tag->getId(),
            'ageGroup' => $ageGroup->getId(),
        ));
    }
}


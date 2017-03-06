<?php

namespace AppBundle\Service\Bieblo\Fetch;

use AppBundle\Entity\AgeGroup;
use AppBundle\Entity\Book;
use AppBundle\Entity\BookTag;
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

    /**
     * @param Tag $tag
     * @param AgeGroup $ageGroup
     * @return array
     */
    public function fetchBooksByTagAndAgeGroup($tag, $ageGroup) {
        return $this->getEntityRepository()->findBy(array(
            'tag' => $tag->getId(),
            'ageGroup' => $ageGroup->getId(),
        ));
    }

    /**
     * @param Book $book
     */
    public function updateAvailability($book) {

        $bookTags = $this->getEntityRepository()->findBy(array(
            'book' => $book->getId()
        ));

        /** @var BookTag $bookTag */
        foreach ($bookTags as $bookTag) {
            $bookTag->setAvailable($book->isAvailable() ? true : false);
            $bookTag->setSubloc($book->getSubloc());
            $bookTag->setShelfmark($book->getShelfmark());
            $this->getEntityManager()->merge($bookTag);
            $this->getEntityManager()->flush();
        }
    }

    public function getRandomBooks($likes, $ageGroup) {
        $qb = $this->getEntityRepository()->createQueryBuilder('bt')->where('bt.tag IN (:tags)');
        $qb->andWhere('bt.ageGroup = :ageGroup');
        $qb->andWhere('bt.available = :available');
        $qb->setParameter('tags', $likes);
        $qb->setParameter('ageGroup', $ageGroup);
        $qb->setParameter('available', 1);
        return $qb->getQuery()->getArrayResult();
    }
}


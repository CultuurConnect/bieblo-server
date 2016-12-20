<?php

namespace AppBundle\Service\Bieblo\Sync;

use AppBundle\Entity\Book;
use AppBundle\Entity\Library;
use AppBundle\Entity\Region;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;
use AppBundle\Service\CultuurConnect\Fetch\Books as fetchBooks;

class Books {
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var fetchBooks
     */
    private $fetchBooks;

    /**
     * Regions constructor.
     * @param EntityManager $entityManager
     * @param Logger $logger
     * @param fetchBooks $fetchBooks
     */
    public function __construct(EntityManager $entityManager, Logger $logger, fetchBooks $fetchBooks)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->fetchBooks = $fetchBooks;
    }

    /**
     * @param string $keyword
     * @param int $ageGroup
     *
     * @return array
     */
    public function syncForKeyword($keyword, $ageGroup) {

        $books = $this->fetchBooks->fetchBooks($keyword, $ageGroup);
        $uow = $this->entityManager->getUnitOfWork();

        $result = [
            'count' => 0,
            'updated' => [],
            'created' => [],
        ];

        /** @var Book $book */
        foreach ($books as $book) {
            $result['count']++;
            $uow->computeChangeSets();
            $changes = $uow->getEntityChangeSet($book);
            if (count($changes)) {
                $result['updated'][] = $book->getId();
                $this->writeLogUpdated($book, $changes);
            }
            if (!$book->getCreatedAt() instanceof \DateTime) {
                $result['created'][] = $book->getId();
                $this->writeLogCreated($book);
            }
        }

        $this->entityManager->flush();

        return $result;
    }

    /**
     * @param Book $book
     * @param array $changes
     */
    protected function writeLogUpdated(Book $book, array $changes)
    {
        $fields = join('; ', array_keys($changes));
        $this->writeLog($book, 'UPDATED', $fields);
    }

    /**
     * @param Book $book
     */
    protected function writeLogCreated(Book $book)
    {
        $this->writeLog($book, 'CREATED');
    }

    /**
     * @param Book $book
     * @param string $action
     * @param string|null $msg
     */
    protected function writeLog(Book $book, $action, $msg = null)
    {
        $msg = 'BOOK {ACTION} {BOOK}' . $msg ? ' ' . $msg : '';
        $context = array(
            'ACTION' => $action,
            'BOOK' => $book->getId(),
        );
        $this->logger->addInfo($msg, $context);
    }
}
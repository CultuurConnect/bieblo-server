<?php
namespace AppBundle\Command;

use AppBundle\Entity\AgeGroup;
use AppBundle\Entity\BookTag;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use AppBundle\Entity\Book;

class SyncExecuteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('sync:execute')
            ->setDescription('Execute single query process')
            ->setHelp('This command will execute a single query');

        $this->addArgument('query', InputArgument::REQUIRED, 'The query')
            ->addArgument('tag-id', InputArgument::REQUIRED, 'The id of the tag');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $query = $input->getArgument('query');
        $tagId = $input->getArgument('tag-id');

        $output->writeln('- Query : ' . $query);

        $ageGroups = $this->getContainer()->get('app.bieblo.fetch.ageGroups')->fetchAgeGroups();
        $tag = $this->getContainer()->get('app.bieblo.fetch.tags')->fetchTagByID($tagId);

        /** @var \AppBundle\Service\CultuurConnect\Fetch\Books $service */
        $service = $this->getContainer()->get('app.cc.fetch.books');

        /** @var AgeGroup $ageGroup */
        foreach ($ageGroups as $ageGroup) {
            $output->writeln('- Executing for ageGroup ' . $ageGroup->getName());

            $service->getEntityManager()->persist($tag);
            $service->getEntityManager()->persist($ageGroup);

            $books = $service->fetchBooks($query, $ageGroup->getId(), true);

            $uow = $service->getEntityManager()->getUnitOfWork();

            $result = [
                'count' => 0,
                'updated' => [],
                'created' => [],
            ];


                /** @var Book $book */
                foreach ($books as $book) {
                    $service->getEntityManager()->persist($book);
                    $result['count']++;
                    $book->setAgeGroup($ageGroup);
                    $uow->computeChangeSets();
                    $changes = $uow->getEntityChangeSet($book);
                    if ($book->getId() === null) {
                        $service->getEntityManager()->flush($book);
                        $result['created'][] = $book->getId();
                    } else if (count($changes)) {
                        $service->getEntityManager()->flush($book);
                        $result['updated'][] = $book->getId();
                    }

                    if (!$this->getContainer()->get('app.bieblo.fetch.bookTags')->fetchBookTag($book, $tag, $ageGroup)) {
                        $bookTag = new BookTag();
                        $bookTag->setAgeGroup($ageGroup);
                        $bookTag->setBook($book);
                        $bookTag->setTag($tag);

                        $service->getEntityManager()->persist($bookTag);
                    }
                }


            $output->writeln('- found ' . count($books) . ' books');
            $output->writeln('- updated ' . count($result['updated']) . ' books');
            $output->writeln('- created ' . count($result['created']) . ' books');

            $service->getEntityManager()->flush();
        }
    }
}
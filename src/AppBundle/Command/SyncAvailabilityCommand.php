<?php
namespace AppBundle\Command;

use AppBundle\Entity\Book;
use AppBundle\Entity\Tag;
use AppBundle\Service\Bieblo\Fetch\BooksFetchService;
use AppBundle\Service\Bieblo\Fetch\BookTagsFetchService;
use AppBundle\StaticData\Queries;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class SyncAvailabilityCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('sync:availablity')
            ->setDescription('Start sync availablity process')
            ->setHelp('This command will start the sync availablity process');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var BooksFetchService $serviceBooks */
        $serviceBooks = $this->getContainer()->get('app.bieblo.fetch.books');
        /** @var BookTagsFetchService $serviceBookTagss */
        $serviceBookTags = $this->getContainer()->get('app.bieblo.fetch.bookTags');
        /** @var \AppBundle\Service\CultuurConnect\Fetch\Availability $serviceAvailability */
        $serviceAvailability = $this->getContainer()->get('app.cc.fetch.availability');
        $numBooks = $serviceBooks->getNumBooks();
        $output->writeln('Got ' . $numBooks . ' books to check availability');

        $numBooksBatch = 10;
        $numBatches = ceil($numBooks / $numBooksBatch);

        for ($batch = 0; $batch <= $numBatches; $batch++ ) {
            $output->writeln('Update books in batch ' . $batch . ' of ' . $numBatches);
            $books = $serviceBooks->fetchBatch($numBooksBatch, $batch);
            /** @var Book $book */
            foreach ($books as $book) {
                $serviceBookTags->updateAvailability($serviceAvailability->fetchAvailability($book));
                $output->write('.');
            }
            $output->writeln('updating availability');

        }

        $output->writeln('update done...');

    }
}
<?php
namespace AppBundle\Command;

use AppBundle\StaticData\Queries;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncRunCommand extends Command
{

    protected function configure()
    {
        $this->setName('sync:run')
            ->setDescription('Start sync process')
            ->setHelp('This command will start the sync process');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tags = Queries::getTags();
        $totalTags = count($tags);

        $output->writeln([
            'Sync process',
            '================',
            'Started - Got ' . $totalTags . ' tags to sync...',
        ]);

        foreach ($tags as $tag => $queries) {
            $output->writeln('- Tag ' . $tag . '/'. $totalTags . ' - has ' . count($queries) . ' queries');

            foreach ($queries as $key => $query) {
                $command = $this->getApplication()->find('sync:execute');

                $arguments = array(
                    'command' => 'sync:execute',
                    'query' => $query,
                    'tag-id' => $tag,
                );

                $syncExecuteInput  = new ArrayInput($arguments);
                $command->run($syncExecuteInput, $output);
            }

            $output->writeln('Query done.');
        }

        $output->writeln('Sync done.');
    }
}
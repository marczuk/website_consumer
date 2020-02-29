<?php

namespace App\Command;

use App\Service\VidexWebsiteConsumerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VidexWebsiteConsumerCommand extends Command
{
    use LockableTrait;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:consume-videx-website';

    /** @var VidexWebsiteConsumerService */
    private $videxWebsiteConsumerService;

    /**
     * VidexWebsiteConsumerCommand constructor.
     * @param VidexWebsiteConsumerService $videxWebsiteConsumerService
     */
    public function __construct(VidexWebsiteConsumerService $videxWebsiteConsumerService)
    {
        parent::__construct();
        $this->videxWebsiteConsumerService = $videxWebsiteConsumerService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Consume Videx website to get list of their products')
            ->setHelp(<<<'HELP'
The <info>%command.name%</info> command lists all the products from Videx website:

  <info>php %command.full_name%</info>

HELP
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int - status code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //prevent running in multiple threads
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return 0;
        }

        try {
            $items = $this->videxWebsiteConsumerService->consume();
        } catch (\Exception $exception) {
            $output->writeln('ERROR : '. $exception->getMessage());
            return 0;
        }

        foreach ($items AS $item) {

            //convert to json - might be changed to separate method if other types of returns needed
            //and select which type of return we want.
            $itemJson = json_encode($item);
            $output->writeln($itemJson);
        }

        $this->release();
        return 0;
    }
}
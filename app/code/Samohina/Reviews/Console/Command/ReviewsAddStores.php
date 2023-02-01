<?php

namespace Samohina\Reviews\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Класс импортирет города и отделения Новой почты в базу данных
 */
class ReviewsAddStores extends Command
{

    private $addingStores;


    public function __construct(
            \Samohina\Reviews\Model\Reviews\AddStores $addingStores,
            string $name = null
    )
    {
        $this->addingStores = $addingStores;
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setName('review:data:stores');
        $this->setDescription('Adding all stores to reviews');

        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Addinging stores to reviews.</info>');
        $this->addingStores->execute(function($message) use($output) {
            $output->writeln('<info>' . $message . '</info>');
        });
    }

}

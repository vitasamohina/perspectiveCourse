<?php

namespace Samohina\CityByIp\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Класс импортирет города и отделения Новой почты в базу данных
 */
class ImportCommand extends Command
{

    private $cityImport;


    private $warehouseImport;

    public function __construct(
            \Samohina\CityByIp\Model\Import\CityImport $cityImport,
            string $name = null
    )
    {
        $this->cityImport = $cityImport;
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setName('novaposhta:data:import');
        $this->setDescription('Import cities from Nova Poshta to database.');

        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Import cities.</info>');
        $this->cityImport->execute(function($message) use($output) {
            $output->writeln('<info>' . $message . '</info>');
        });
    }

}

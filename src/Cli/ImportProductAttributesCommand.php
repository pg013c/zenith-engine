<?php

declare(strict_types=1);

namespace App\Cli;

use App\Service\ImportProductAttributesService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'zenith:import-product-attributes')]
class ImportProductAttributesCommand extends Command
{
    public function __construct(
        private readonly ImportProductAttributesService $importProductAttributesService
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Import product attributes')
            ->setHelp('This command allows you to create a user...')
            ->addArgument('path', InputArgument::REQUIRED, 'Import path')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ini_set('memory_limit', '512M');

        $output->writeln('Importing product attributes...');

        $dirPath = $input->getArgument('path');

        $this->importProductAttributesService->import($dirPath);

        return Command::SUCCESS;
    }
}
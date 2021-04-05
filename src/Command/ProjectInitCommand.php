<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ProjectInitCommand extends Command
{
    protected static $defaultName = 'app:project-init';
    protected static $defaultDescription = 'Project init with create database, migrations, fixtures, tests.';

    const COMMANDS = [
        'Create database' => 'doctrine:database:create',
        'Execute migrations' => 'doctrine:migrations:migrate',
        'Loading fixtures' => 'doctrine:fixtures:load',
    ];

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        foreach (self::COMMANDS as $message => $command) {
            $output->writeln([
                $message,
                '============',
            ]);

            $command = $this->getApplication()->find($command);
            $command->run(new ArrayInput([]), $output);
        }

        $io->success('Project init!');

        return Command::SUCCESS;
    }
}

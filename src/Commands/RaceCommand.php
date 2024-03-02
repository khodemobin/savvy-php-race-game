<?php

namespace RaceCli\Console\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RaceCommand extends Command
{
    protected string $command = 'race';

    protected string $description = 'Run race game!';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        echo "Hi there :)\n";

        return self::SUCCESS;
    }
}
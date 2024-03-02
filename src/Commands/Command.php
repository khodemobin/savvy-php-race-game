<?php

namespace RaceCli\Console\Commands;

use Symfony\Component\Console\Command\Command as AbstractCommand;

abstract class Command extends AbstractCommand
{
    protected string $command;

    protected string $description;

    protected function configure(): void
    {
        $this->setName($this->command);
        $this->setDescription($this->description);
    }
}
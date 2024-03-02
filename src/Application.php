<?php
declare(strict_types=1);

namespace RaceCli\Console;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Application extends ConsoleApplication
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(private readonly ContainerInterface $container)
    {
        parent::__construct("php-race-app", "1.0.0");
    }


    /**
     * @throws \Exception
     */
    public function run(InputInterface $input = null, OutputInterface $output = null): int
    {
        return parent::run($input, $output);
    }
}
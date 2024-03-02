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
        $config = $this->container->get('config');
        parent::__construct($config['name'], $config['version']);
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \Exception
     */
    public function run(InputInterface $input = null, OutputInterface $output = null): int
    {
        $this->setAutoExit(false);
        $config = $this->container->get('config');
        foreach ($config['commands'] as $command) {
        }

        return parent::run($input, $output);
    }
}
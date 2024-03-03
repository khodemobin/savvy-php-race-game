<?php
declare(strict_types=1);

namespace RaceCli\Console;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends ConsoleApplication
{
    private static ContainerInterface $container;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        self::$container = $container;
        $config = $container->get('config');
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
        $config = self::container()->get('config');
        foreach ($config['commands'] as $command) {
            $this->add(self::container()->get($command));
        }

        return parent::run($input, $output);
    }

    public static function container(): ContainerInterface
    {
        return self::$container;
    }
}
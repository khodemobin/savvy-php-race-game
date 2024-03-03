<?php

namespace RaceCli\Test\Commands;

use PHPUnit\Framework\TestCase;
use RaceCli\Test\CreateApp;
use Symfony\Component\Console\Tester\CommandTester;

class RaceCommandTest extends TestCase
{
    use CreateApp;

    public function test_vehicle_picker(): void
    {
        $command = $this->app()->find('race');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs([1, 2]);
        $commandTester->execute(['command' => $command->getName()]);
        $commandTester->assertCommandIsSuccessful();
        $result = $commandTester->getDisplay(true);
        $this->assertTrue(str_contains($result, "Player one: Motorcycle, player two: Bus"));
    }
}
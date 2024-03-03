<?php

namespace RaceCli\Test\Commands;

use PHPUnit\Framework\TestCase;
use RaceCli\Test\CreateApp;
use Symfony\Component\Console\Tester\CommandTester;

class RaceCommandTest extends TestCase
{
    use CreateApp;

    private array $testCases = [
        [
            "inputs" => [1, 2],
            "players" => "Player one: Motorcycle, player two: Bus",
            "winner" => "The Winner vehicle is Motorcycle finished in 5 hours",
            "second" => "The Second vehicle is Bus finished in 10 hours"
        ],
        [
            "inputs" => [1, 8],
            "players" => "Player one: Motorcycle, player two: Airplane",
            "winner" => "The Winner vehicle is Airplane finished in 1.11 hours",
            "second" => "The Second vehicle is Motorcycle finished in 5 hours"
        ]
    ];

    public function test_race_game(): void
    {
        $command = $this->app()->find('race');

        foreach ($this->testCases as $testCase) {
            $commandTester = new CommandTester($command);
            $commandTester->setInputs($testCase["inputs"]);
            $commandTester->execute(['command' => $command->getName()]);
            $commandTester->assertCommandIsSuccessful();
            $result = $commandTester->getDisplay(true);

            $this->assertTrue(str_contains($result, $testCase["players"]));
            $this->assertTrue(str_contains($result, $testCase["winner"]));
            $this->assertTrue(str_contains($result, $testCase["second"]));
        }
    }
}
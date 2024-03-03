<?php

namespace RaceCli\Console\Commands;

use RaceCli\Console\Application;
use RaceCli\Console\Entities\Vehicle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class RaceCommand extends Command
{
    protected string $command = 'race';

    protected string $description = 'Run race game!';

    private array $vehicles;

    public function __construct(?string $name = null)
    {
        $config = Application::container()->get('config');
        $this->vehicles = json_decode(file_get_contents($config["vehicles_path"]));
        parent::__construct($name);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $players = $this->vehiclePicker($input, $output);

        //
        return self::SUCCESS;
    }


    // Ask players to choose their vehicles
    public function vehiclePicker(InputInterface $input, OutputInterface $output): array
    {
        $players = [];
        for ($i = 0; $i < 2; $i++) {
            $question = new ChoiceQuestion("Player $i, choose your vehicle:", array_map(static fn($vehicle) => $vehicle->name, $this->vehicles));
            $choice = $this->getHelper('question')->ask($input, $output, $question);
            $playerIndex = array_search($choice, array_map(static fn($vehicle) => $vehicle->name, $this->vehicles), true);
            $players[$i] = Vehicle::fromObject($this->vehicles[$playerIndex]);
        }

        $output->writeln("Player one: {$players[0]->name}, player two: {$players[1]->name}");
        return $players;
    }
}
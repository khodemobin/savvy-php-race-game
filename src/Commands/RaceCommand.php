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
    private int $distance;

    public function __construct(?string $name = null)
    {
        $config = Application::container()->get('config');
        $this->vehicles = json_decode(file_get_contents($config["vehicles_path"]));
        $this->distance = $config["race_distance"];
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $players = $this->vehiclePicker($input, $output);
        $this->calculateResults($output, $players);
        //
        return self::SUCCESS;
    }


    /**
     * Ask players to choose their vehicles
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return array<Vehicle>
     */
    private function vehiclePicker(InputInterface $input, OutputInterface $output): array
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

    /**
     * @param OutputInterface $output
     * @param array<Vehicle> $players
     * @return void
     */
    private function calculateResults(OutputInterface $output, array $players): void
    {
        foreach ($players as $vehicle) {
            $vehicle->finishTime = round($this->distance / $vehicle->getMaxSpeedInKmH(), 2);
        }

        // sort players by finishTime to detect winner
        array_multisort(array_column($players, 'finishTime'), SORT_ASC, $players);

        $output->writeln("The Winner vehicle is {$players[0]->name} finished in {$players[0]->finishTime} hours");
        $output->writeln("The Second vehicle is {$players[1]->name} finished in {$players[1]->finishTime} hours");
    }
}
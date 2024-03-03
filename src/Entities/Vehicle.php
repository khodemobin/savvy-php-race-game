<?php

namespace RaceCli\Console\Entities;

class Vehicle
{
    public function __construct(
        public string $name,
        public int    $maxSpeed,
        public string $unit,
    )
    {
    }

    public static function fromObject(mixed $vehicle): self
    {
        return new self(
            name: $vehicle->name,
            maxSpeed: $vehicle->maxSpeed,
            unit: $vehicle->unit
        );
    }

    public function getMaxSpeedInKmH(): float
    {
        $conversionFactor = match ($this->unit) {
            "knots", "Kts" => 1.852,
            default => 1
        };

        return $this->maxSpeed * $conversionFactor;
    }

}
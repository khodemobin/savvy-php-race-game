<?php

use Symfony\Component\Yaml\Yaml;

$container = new DI\Container([
    'config' => Yaml::parse(file_get_contents(__DIR__ . './../config/config.yaml')),
]);


return $container;
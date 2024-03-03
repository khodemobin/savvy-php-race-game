<?php

namespace RaceCli\Test;

use RaceCli\Console\Application;

trait CreateApp
{
    public function app()
    {
        $container = require __DIR__ . './../bootstrap/bootstrap.php';
        $app = new Application($container);
        $app->run();

        return $app;
    }
}
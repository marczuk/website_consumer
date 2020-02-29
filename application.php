#!/usr/bin/env php
<?php

/*
 * Resign to use application.php as an entry point
 * In symfony it is not working with DI and workaround for it is not working with framework.yaml setup correctly
 */

require __DIR__.'/vendor/autoload.php';

use App\AppKernel;
//use Symfony\Component\Console\Application;
use Symfony\Bundle\FrameworkBundle\Console\Application;


//require __DIR__.'/config/bootstrap.php';


//$kernel = new AppKernel('dev', true);
//$kernel->boot();

//$container = $kernel->getContainer();
//$application = $container->get(Application::class);
//$application->run();


$kernel = new AppKernel('dev', true);
$application = new Application($kernel);
$application->run();
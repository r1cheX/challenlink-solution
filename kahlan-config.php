<?php

use Kahlan\Filter\Filters;

$commandLine = $this->commandLine();
$commandLine->option('coverage', 'default', 4);
$commandLine->option('reporter', 'default', 'verbose');

Filters::apply($this, 'run', function($next) {
    // Set up autoloading
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/vendor/autoload.php';
    }
    
    return $next();
});

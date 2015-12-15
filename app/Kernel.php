<?php

namespace App;

use PDO;
use Unf\AppKernel;

class Kernel extends AppKernel
{
    public function __construct()
    {
        parent::__construct();

        // Alias classes for easy access from routes and views
        class_alias('Unf\\HTTP\\Request', 'Request');
        class_alias('Unf\\View', 'View');

        // Connect to the database
        $dbConfig = $this->config['db'][$this->config['environment']];
        $GLOBALS['db'] = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        unset($dbConfig);

        // Get common functions
        require __DIR__ . '/common.php';

        // Are we in development?
        if ($this->config['environment'] == 'development') {
            require "{$this->configDir}/environment/development.php";
        }
    }
}

<?php
require __DIR__ . '/vendor/autoload.php';

define('START_TIME', microtime(true));
define('START_MEM', memory_get_usage());
define("DOCROOT", __DIR__);

(new App\Kernel)->run();

<?php
/*!
 * Unframework
 * Copyright (c) 2015 Jack P.
 *
 * Unframework is released under the MIT license.
 */

namespace Unf;

use Exception;
use ReflectionClass;
use Unf\HTTP\Request;
use Unf\Router;
use Unf\View;

/**
 * Application kernel.
 *
 * @package Unf
 * @author Jack P.
 * @since 0.1
 */
class AppKernel
{
    /**
     * Application directory path.
     *
     * @var string
     */
    protected $path;

    /**
     * Configuration directory path.
     *
     * @var string
     */
    protected $configDir;

    /**
     * Configuration.
     *
     * @var array
     */
    protected $config;

    public function __construct()
    {
        $r = new \ReflectionObject($this);
        $this->path = dirname($r->getFileName());
        $this->configDir = dirname($this->path) . '/config';

        $this->loadConfiguration();
        $this->loadRoutes();
        $this->configureTemplating();
    }

    /**
     * Load configuration.
     */
    protected function loadConfiguration()
    {
        if (file_exists("{$this->configDir}/config.php")) {
            $this->config = require "{$this->configDir}/config.php";
        } else {
            throw new Exception("Unable to load config file");
        }
    }

    /**
     * Load routes.
     */
    protected function loadRoutes()
    {
        if (file_exists("{$this->configDir}/routes.php")) {
            Router::$routes = require "{$this->configDir}/routes.php";
        } else {
            throw new Exception("Unable to load routes file");
        }
    }

    /**
     * Setup the view class.
     */
    protected function configureTemplating()
    {
        View::addPath("{$this->path}/views");
    }

    /**
     * Process the request.
     */
    public function run()
    {
        Request::init();
        $route = Router::process();

        if ($route) {
            Kernel::process("{$this->path}/{$route}");
        } else {
            throw new NoRouteFoundException(sprintf("No route matches [%s]", Request::$pathInfo));
        }
    }
}

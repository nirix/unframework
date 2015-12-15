<?php
/*!
 * Unframework
 * Copyright (c) 2015 Jack P.
 *
 * Unframework is released under the MIT license.
 */

namespace Unf;

use Exception;
use Unf\Language;
use Unf\Router;

/**
 * PHP "template" renderer.
 *
 * @package Unf
 * @author Jack P.
 * @since 1.0
 */
class View
{
    /**
     * Paths to search for templates in.
     *
     * @var string[]
     */
    protected static $paths = [];

    /**
     * Global variables.
     *
     * @var array
     */
    protected static $globals = array();

    /**
     * Adds a global variable for all templates.
     *
     * @param string $name
     * @param mixed  $value
     */
    public static function set($name, $value)
    {
        static::$globals[$name] = $value;
    }

    /**
     * Adds a template path to search in.
     *
     * @param string|array $path
     */
    public static function addPath($path, $prepend = false)
    {
        if ($prepend) {
            static::$paths = array_merge([$path], static::$paths);
        } else {
            static::$paths[] = $path;
        }
    }

    /**
     * @param string $template
     * @param array  $locals
     *
     * @return string
     */
    public static function render($template, array $locals = [])
    {
        $templatePath = static::find($template);

        if (!$templatePath) {
            $paths = implode(', ', static::$paths);
            throw new Exception("Unable to find template [$template] searched in [{$paths}]");
        }

        // View variables
        $variables = $locals + static::$globals;
        foreach ($variables as $_name => $_value) {
            $$_name = $_value;
        }

        ob_start();
        include($templatePath);
        return ob_get_clean();
    }

    /**
     * Checks if the template exists.
     *
     * @param string $template
     *
     * @return bool
     */
    public static function exists($template)
    {
        return static::find($template) ? true : false;
    }

    /**
     * Searches for the template in the registered search paths.
     *
     * @param string $template
     *
     * @return string|bool
     */
    public static function find($template)
    {
        foreach (static::$paths as $path) {
            $filePath = "{$path}/{$template}";

            if (file_exists($filePath)) {
                return $filePath;
            }
        }

        return false;
    }
}

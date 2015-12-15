<?php
/*!
 * Unframework
 * Copyright (c) 2015 Jack P.
 *
 * Unframework is released under the MIT license.
 */

namespace Unf;

use Exception;
use Unf\HTTP\Request;

/**
 * Request router.
 *
 * @package Unf
 * @author Jack P.
 * @since 0.1
 */
class Router
{
    /**
     * Routes.
     *
     * @var array
     */
    public static $routes = [];

    /**
     * Route tokens.
     *
     * @var array
     */
    public static $tokens = [
        'id'   => "(?<id>\d+)",
        'slug' => "(?<slug>[^/]+)"
    ];

    /**
     * Route extensions.
     *
     * @var array
     */
    public static $extensions = ['json', 'atom'];

    /**
     * Add route token.
     *
     * @param string $name
     * @param mixed  $regex
     */
    public static function addToken($name, $regex)
    {
        static::$tokens[$name] = $regex;
    }

    /**
     * Process the request.
     *
     * @return Route
     */
    public static function process()
    {
        $pathInfo = Request::$pathInfo;

        if (isset(static::$routes[$pathInfo])) {
            return static::$routes[$pathInfo];
        } else {
            foreach (static::$routes as $route => $dest) {
                $pattern = static::regex($route);

                if (preg_match($pattern, Request::$pathInfo, $matches)) {
                    unset($matches[0]);
                    Request::$properties->set($matches);
                    return $dest;
                }
            }
        }

        return false;
    }

    /**
     * Wrap the passed regex pattern and add the file extension pattern.
     *
     * @param  string $pattern
     *
     * @return string
     */
    protected static function regex($pattern)
    {
        foreach (static::$tokens as $name => $value) {
            $pattern = str_replace("{{$name}}", $value, $pattern);
        }

        $extensions = static::extensionsRegex();
        return "%^{$pattern}{$extensions}$%sU";
    }

    /**
     * Returns compiled extensions regex group.
     *
     * @return string
     */
    protected static function extensionsRegex()
    {
        $extensions = [];

        foreach (static::$extensions as $extension) {
            $extensions[] = preg_quote($extension, '%');
        }

        return "(\.(?P<extension>" . implode("|", $extensions) . '))?';
    }
}

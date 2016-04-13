<?php
/*!
 * Unframework
 * Copyright (c) 2015-2016 Jack P.
 *
 * Unframework is released under the MIT license.
 */

namespace Unf;

/**
 * HTTP request.
 *
 * @author Jack P.
 * @package Unf\HTTP
 * @since 0.1
 */
class Request
{
    /**
     * Holds the $_GET parameters.
     *
     * @var ParameterBag
     */
    public static $query;

    /**
     * Holds the $_POST parameters.
     *
     * @var ParameterBag
     */
    public static $post;

    /**
     * Custom request attributes.
     *
     * @var ParameterBag
     */
    public static $properties;

    /**
     * Holds the $_SERVER parameters.
     *
     * @var ParameterBag
     */
    public static $server;

    /**
     * Request headers.
     *
     * @var ParameterBag
     */
    public static $headers;

    /**
     * Request method.
     *
     * @var string
     */
    public static $method;

    /**
     * @var string
     */
    public static $pathInfo;

    /**
     * @var string
     */
    public static $requestUri;

    /**
     * @var string
     */
    public static $scriptName;

    /**
     * @var string
     */
    public static $basePath;

    /**
     * @var array
     */
    public static $segments = [];

    public function __construct()
    {
        static::init();
    }

    /**
     * Sets up the request.
     */
    public static function init()
    {
        static::$query      = new ParameterBag($_GET);
        static::$post       = new ParameterBag($_POST);
        static::$properties = new ParameterBag();
        static::$server     = new ParameterBag($_SERVER);
        static::$headers    = static::buildHeaderBag();
        static::$method     = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

        static::$requestUri = $_SERVER['REQUEST_URI'];
        static::$scriptName = $_SERVER['SCRIPT_NAME'];
        static::$basePath = rtrim(str_replace(basename(static::$scriptName), '', static::$scriptName), '/');
        static::$pathInfo = str_replace(static::$scriptName, '', static::$requestUri);
        static::$pathInfo = static::preparePathInfo();

        static::$segments = explode('/', trim(static::$pathInfo, '/'));
    }

    /**
     * Separates the headers from `$_SERVER`.
     *
     * @return ParameterBag
     */
    protected static function buildHeaderBag()
    {
        $headers = [];

        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == 'HTTP_') {
                $key = substr($key, 5);
                $key = str_replace('_', ' ', strtolower($key));
                $key = str_replace(' ', '-', ucwords($key));

                $headers[$key] = $value;
            }
        }

        return new ParameterBag($headers);
    }

    /**
     * @return boolean
     */
    public static function matches($path)
    {
        foreach (static::$properties->properties as $property => $value) {
            $path = str_replace("{{$property}}", $value, $path);
        }

        return preg_match("#^{$path}$#", static::$pathInfo);
    }

    /**
     * @param integer $index
     * @param mixed   $fallback
     *
     * @return mixed
     */
    public static function seg($index, $fallback = null)
    {
        return isset(static::$segments[$index]) ? static::$segments[$index] : $fallback;
    }

    /**
     * Get path info without the query string.
     *
     * @return string
     */
    protected static function preparePathInfo()
    {
        $path = '/' . trim(preg_replace('%^' . dirname(static::$scriptName) . '%i', '', static::$pathInfo), '/');

        if (strpos($path, '?')) {
            $path = str_replace('?' . $_SERVER['QUERY_STRING'], '', $path);
        }

        return $path;
    }
}

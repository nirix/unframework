<?php
/*!
 * Unframework
 * Copyright (c) 2015-2016 Jack P.
 *
 * Unframework is released under the MIT license.
 */

namespace Unf;

use Unf\Request;

/**
 * @package Unf
 * @author Jack P.
 * @since 0.1
 */
class Kernel
{
    const VERSION = '0.1.0';

    /**
     * This is used to isolate the routed file from the application kernel.
     */
    public static function process($route)
    {
        $response = require $route;

        if (is_string($response)) {
            echo $response;
        }
    }
}

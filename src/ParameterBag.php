<?php
/*!
 * Unframework
 * Copyright (c) 2015-2016 Jack P.
 *
 * Unframework is released under the MIT license.
 */

namespace Unf;

use ArrayAccess;

/**
 * @author Jack P.
 * @package Unf
 * @since 0.1
 */
class ParameterBag implements ArrayAccess
{
    /**
     * @var array
     */
    public $properties = [];

    /**
     * @param array $properties
     */
    public function __construct(array $properties = [])
    {
        $this->properties = $properties;
    }

    /**
     * @param string $property
     *
     * @return boolean
     */
    public function has($property)
    {
        return isset($this->properties[$property]) ? $this->properties[$property] : false;
    }

    /**
     * @param string $property
     * @param mixed  $value
     */
    public function set($property, $value = null)
    {
        // Check if we're trying to set multiple properties.
        if (is_array($property)) {
            foreach ($property as $prop => $value) {
                $this->set($prop, $value);
            }
        } else {
            $this->properties[$property] = $value;
        }
    }

    /**
     * @param string $property
     * @param mixed  $fallback
     *
     * @return mixed
     */
    public function get($property, $fallback = null)
    {
        return isset($this->properties[$property]) ? $this->properties[$property] : $fallback;
    }


    // -------------------------------------------------------------------------
    // ArrayAccess

    public function offsetExists($offset)
    {
        return isset($this->properties[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->properties[$offset]) ? $this->properties[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->properties[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->properties[$offset]);
    }
}

<?php

namespace ishop;
class Registry
{
    use TSingletone;

    private static $properties = [];

    public function setProperty($name, $value)
    {
        static::$properties[$name] = $value;
    }


    public function getPropertie($name)
    {
        if(isset(static::$properties[$name]))
            return static::$properties[$name];
        return null;
    }

    public  function getProperties(): array {
        return static::$properties;
    }
}
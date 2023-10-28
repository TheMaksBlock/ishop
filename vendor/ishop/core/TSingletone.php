<?php

namespace ishop;

trait TSingletone
{
    private static  $instance;

    public static function instance()
    {
        if(static::$instance === null)
            static::$instance = new static();

        return static::$instance;
    }
}
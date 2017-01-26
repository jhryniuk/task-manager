<?php

class ParameterBag
{
    private static $parameters = [
        'storage'       => 'memory',
        'xml_location'  => 'data.xml'
    ];

    public static function get($parameter)
    {
        if (array_key_exists($parameter, self::$parameters)) {
            return self::$parameters[$parameter];
        } else {
            return null;
        }
    }
}

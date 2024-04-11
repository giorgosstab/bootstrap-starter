<?php

namespace App\Libraries;

class ConfigManager
{
    private static array $items = [];

    /**
     * @param $key
     * @param $default
     * @return array|string|null
     */
    public static function get($key, $default = null): array|string|null
    {
        [$group, $name] = explode('.', $key, 2);

        if (!isset(self::$items[$group])) {
            $config = config_path($group . '.php');

            if (file_exists($config)) {
                self::$items[$group] = require $config;
            } else {
                return $default;
            }
        }

        return self::getValueFromArray(self::$items[$group], $name, $default);
    }

    private static function getValueFromArray($array, $key, $default)
    {
        $keys = explode('.', $key);
        $value = $array;

        foreach ($keys as $subKey) {
            if (isset($value[$subKey])) {
                $value = $value[$subKey];
            } else {
                return $default;
            }
        }

        return $value;
    }
}
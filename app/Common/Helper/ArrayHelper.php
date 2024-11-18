<?php

namespace App\Common\Helper;

use Closure;
use Hyperf\Contract\Arrayable;

class ArrayHelper
{
    public static function toArray($object, $properties = [], $recursive = true): array
    {
        if (is_array($object)) {
            if ($recursive) {
                /** @var array $object */
                foreach ($object as $key => $value) {
                    if (is_array($value) || is_object($value)) {
                        $object[$key] = static::toArray($value, $properties, true);
                    }
                }
            }

            return $object;
        }

        if (is_object($object)) {
            if (!empty($properties)) {
                $className = get_class($object);
                if (!empty($properties[$className])) {
                    $result = [];
                    foreach ($properties[$className] as $key => $name) {
                        if (is_int($key)) {
                            $result[$name] = $object->$name;
                        } else {
                            $result[$key] = static::getValue($object, $name);
                        }
                    }

                    return $recursive ? static::toArray($result, $properties) : $result;
                }
            }
            if ($object instanceof Arrayable) {
                $result = $object->toArray();
            } else {
                $result = [];
                /** @var array $object */
                foreach ($object as $key => $value) {
                    $result[$key] = $value;
                }
            }

            return $recursive ? static::toArray($result, $properties) : $result;
        }

        return [$object];
    }

    public static function getValue($array, $key, $default = null)
    {
        if ($key instanceof Closure) {
            return $key($array, $default);
        }

        if (is_array($key)) {
            $lastKey = array_pop($key);
            /** @var array $key */
            foreach ($key as $keyPart) {
                $array = static::getValue($array, $keyPart);
            }
            $key = $lastKey;
        }

        if (is_array($array) && (isset($array[$key]) || array_key_exists($key, $array))) {
            return $array[$key];
        }

        if (is_string($key) && ($pos = strrpos($key, '.')) !== false) {
            $array = static::getValue($array, substr($key, 0, $pos), $default);
            $key = (string)substr($key, $pos + 1);
        }

        if (is_object($array)) {
            return $array->$key;
        }

        if (is_array($array)) {
            return (isset($array[$key]) || array_key_exists($key, $array)) ? $array[$key] : $default;
        }

        return $default;
    }

    public static function filter($array, $filters)
    {
        $result = [];
        $excludeFilters = [];

        foreach ($filters as $filter) {
            if (!is_string($filter) && !is_int($filter)) {
                continue;
            }

            if (is_string($filter) && strpos($filter, '!') === 0) {
                $excludeFilters[] = substr($filter, 1);
                continue;
            }

            $nodeValue = $array;
            $keys = explode('.', (string)$filter);
            foreach ($keys as $key) {
                if (!array_key_exists($key, $nodeValue)) {
                    continue 2;
                }
                $nodeValue = $nodeValue[$key];
            }

            $resultNode = &$result;
            foreach ($keys as $key) {
                if (!array_key_exists($key, $resultNode)) {
                    $resultNode[$key] = [];
                }
                $resultNode = &$resultNode[$key];
            }
            $resultNode = $nodeValue;
        }

        foreach ($excludeFilters as $filter) {
            $excludeNode = &$result;
            $keys = explode('.', (string)$filter);
            $numNestedKeys = count($keys) - 1;
            foreach ($keys as $i => $key) {
                if (!array_key_exists($key, $excludeNode)) {
                    continue 2;
                }

                if ($i < $numNestedKeys) {
                    $excludeNode = &$excludeNode[$key];
                } else {
                    unset($excludeNode[$key]);
                    break;
                }
            }
        }

        return $result;
    }
}
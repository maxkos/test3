<?php

namespace app\traits;

/**
 * Trait EnumTrait
 * @package app\traits
 */
trait EnumTrait
{
    /**
     * @var array
     */
    protected static array $_constCache = [];

    /**
     * @param null $prefix
     * @param array $exclude
     *
     * @return mixed
     */
    public static function getConstants($prefix = null, array $exclude = []): mixed
    {
        $class = get_called_class();

        if (!isset(self::$_constCache[$class]['all'])) {
            $reflect = new \ReflectionClass(get_called_class());
            self::$_constCache[$class]['all'] = $reflect->getConstants();
        }

        if ($prefix) {
            if (!isset(self::$_constCache[$class][$prefix])) {
                $prefixLen = strlen($prefix);
                foreach (($_constCache = self::$_constCache[$class]['all']) as $key => $value) {
                    if (($shortKey = substr($key, 0, $prefixLen)) != $prefix)
                        unset($_constCache[$key]);
                }
                self::$_constCache[$class][$prefix] = $_constCache;
            }

            return array_filter(
                self::$_constCache[$class][$prefix],
                function ($key) use ($exclude) {
                    return !in_array($key, $exclude);
                },
                ARRAY_FILTER_USE_KEY
            );
        }

        return self::$_constCache[$class]['all'];
    }

    /**
     * Return constant value by name
     *
     * @param string $key
     *
     * @return null
     */
    public static function getConstant(string $key): null
    {
        $constants = self::getConstants();

        return array_key_exists($key, $constants) ? $constants[$key] : null;
    }

    /**
     * Return constant name by value
     *
     * @param string $key
     * @param null $prefix
     *
     * @return false|int|string
     */
    public static function getConstantName(string $key, $prefix = null): false|int|string
    {
        $constants = self::getConstants($prefix);

        return array_search($key, $constants);
    }
}
<?php

namespace app\components\hash;
class KHash implements GeneratorInterface
{
    public static $map = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

    /**
     * @param string $string
     * @return string
     */
    public function generate(string $string): string
    {

        $hash = bcadd(sprintf('%u', crc32($string)), 0x100000000);
        $str = "";
        do {
            $str = self::$map[bcmod($hash, 62)] . $str;
            $hash = bcdiv($hash, 62);
        } while ($hash >= 1);
        return $str;
    }
}
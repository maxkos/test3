<?php

namespace app\components\hash;
interface GeneratorInterface
{
    /**
     * @param string $string
     * @return string
     */
    public function generate(string $string): string;
}

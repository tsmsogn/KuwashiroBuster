<?php

namespace KuwashiroBuster\Constraints;

class Generation
{
    CONST GENERATION_1 = 1;
    CONST GENERATION_2 = 2;
    CONST GENERATION_3 = 3;

    /**
     * @return array
     */
    public static function getList()
    {
        return array(
            self::GENERATION_1,
            self::GENERATION_2,
            self::GENERATION_3
        );
    }
}
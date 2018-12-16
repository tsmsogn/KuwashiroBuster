<?php

namespace KuwashiroBuster\Constraints;

class CoverType
{
    CONST ROTEN = 1;
    CONST HITIE_HIFUKU = 2;
    CONST FUTAE_HIFUKU = 4;
    CONST BANGARI = 8;

    /**
     * @return array
     */
    public static function getList()
    {
        return [
            self::ROTEN,
            self::HITIE_HIFUKU,
            self::FUTAE_HIFUKU,
            self::BANGARI
        ];
    }
}
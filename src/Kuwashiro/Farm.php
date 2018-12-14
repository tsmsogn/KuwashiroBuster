<?php

namespace KuwashiroBuster\Kuwashiro;


class Farm implements FarmInterface
{
    CONST TUZYO = 1;
    CONST HIFUKU1 = 2;
    CONST HIFUKU2 = 3;
    CONST BANGARICYOKUGO = 4;

    /**
     * @var int
     */
    public $_type;

    public function __construct($type)
    {
        $this->_type = $type;
    }

    public static function getAvailableTypes()
    {
        return [
            self::TUZYO,
            self::HIFUKU1,
            self::HIFUKU2,
            self::BANGARICYOKUGO
        ];
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->_type;
    }
}
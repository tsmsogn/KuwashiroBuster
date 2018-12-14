<?php

namespace KuwashiroBuster\Calculator;

use KuwashiroBuster\Kuwashiro\Farm;
use KuwashiroBuster\Kuwashiro\FarmInterface;
use KuwashiroBuster\Kuwashiro\Kuwashiro;
use KuwashiroBuster\Kuwashiro\KuwashiroInterface;

class Calculator implements CalculatorInterface
{
    /**
     * 茶株内温度を計算する
     *
     * @param $kion 気温
     * @param $coverType
     * @return float
     */
    public function calcChakabunaiOndo($kion, FarmInterface $coverType)
    {
        switch ($coverType->getType()) {
            case Farm::TUZYO:
                $y = 0.9608 * $kion - 0.2239;
                break;
            case Farm::HIFUKU1:
                $y = 0.8124 * $kion + 1.2012;
                break;
            case Farm::HIFUKU2:
                $y = 0.7437 * $kion + 2.1705;
                break;
            case Farm::BANGARICYOKUGO:
                $y = 1.1749 * $kion - 3.1831;
                break;
            default:
                $y = 0;
                break;
        }

        return $y;
    }

    /**
     * 日当たり有効温度を計算する
     *
     * @param $chakabunaiOndo
     * @param $generationType
     * @return float|int
     * @throws \InvalidArgumentException
     */
    public function calcHiatariYukoOndo($chakabunaiOndo, KuwashiroInterface $kuwashiro)
    {
        $res = 0;

        switch ($kuwashiro->getGeneration()) {
            case Kuwashiro::GENERATION_1:
                $res = ($chakabunaiOndo - 10.5) / 24;
                break;
            case Kuwashiro::GENERATION_2:
            case Kuwashiro::GENERATION_3:
                if ($chakabunaiOndo >= 30) {
                    $chakabunaiOndo = 0;
                }
                $res = ($chakabunaiOndo - 10.8) / 24;
                break;
            default:
                break;
        }

        return ($res > 0) ? $res : 0;
    }
}
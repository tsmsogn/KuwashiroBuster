<?php

namespace KuwashiroBuster\Processor;

use KuwashiroBuster\Constraints\CoverType;
use KuwashiroBuster\Constraints\Generation;

class Processor implements ProcessorInterface
{
    /**
     * 気温を茶株内温度に変換する
     *
     * @param $temperature
     * @param $coverType
     * @return float|int
     */
    public function toChakabunaiOndo($temperature, $coverType)
    {
        switch ($coverType) {
            case CoverType::ROTEN:
                $y = 0.9608 * $temperature - 0.2239;
                break;
            case CoverType::HITIE_HIFUKU:
                $y = 0.8124 * $temperature + 1.2012;
                break;
            case CoverType::FUTAE_HIFUKU:
                $y = 0.7437 * $temperature + 2.1705;
                break;
            case CoverType::BANGARI:
                $y = 1.1749 * $temperature - 3.1831;
                break;
            default:
                $y = 0;
                break;
        }

        return $y;
    }

    /**
     * 茶株内温度を有効積算温度に変換する
     *
     * @param $chakabunaiTemperature
     * @param $generation
     * @return float|int
     */
    public function toYukoSekisanOndo($chakabunaiTemperature, $generation)
    {
        $res = 0;

        switch ($generation) {
            case Generation::GENERATION_1:
                $res = ($chakabunaiTemperature - 10.5) / 24;
                break;
            case Generation::GENERATION_2:
            case Generation::GENERATION_3:
                if ($chakabunaiTemperature >= 30) {
                    $chakabunaiTemperature = 0;
                }
                $res = ($chakabunaiTemperature - 10.8) / 24;
                break;
            default:
                break;
        }

        return ($res > 0) ? $res : 0;
    }
}
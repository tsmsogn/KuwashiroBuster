<?php

namespace KuwashiroBuster\Processor;

use KuwashiroBuster\Constraints\CoverType;
use KuwashiroBuster\Constraints\Generation;

class Processor implements ProcessorInterface
{
    /**
     * 世代ごとの有効積算温度を返す
     *
     * @return array
     */
    public function getYukoSekisanOndos()
    {
        return array(
            Generation::GENERATION_1 => 287,
            Generation::GENERATION_2 => 688,
            Generation::GENERATION_3 => 688
        );
    }

    /**
     * 世代ごとの発育ゼロ点を返す
     *
     * @return array
     */
    public function getHatsuikuZeroTens()
    {
        return array(
            Generation::GENERATION_1 => 10.5,
            Generation::GENERATION_2 => 10.8,
            Generation::GENERATION_3 => 10.8,
        );
    }

    /**
     * 世代ごとの発育停止温度を返す
     *
     * @return array
     */
    public function getHatsuikuTeishiOndos()
    {
        return array(
            Generation::GENERATION_1 => INF,
            Generation::GENERATION_2 => 30,
            Generation::GENERATION_3 => 30,
        );
    }

    /**
     * 気温を茶株内温度に変換する
     *
     * @param $temperature
     * @param $coverType
     * @return float|int
     */
    public function toChakabunaiOndo($temperature, $coverType)
    {
        $y = 0;

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
                break;
        }

        return $y;
    }

    /**
     * 茶株内温度を日当たり有効温度に変換する
     *
     * @param $chakabunaiOndo
     * @param $generation
     * @return float|int
     */
    public function toHiatariYukoOndo($chakabunaiOndo, $generation)
    {
        $hatsuikuTeishiOndos = $this->getHatsuikuTeishiOndos();
        $hatsuikuZeroTens = $this->getHatsuikuZeroTens();

        $hatsuikuTeishiOndo = $hatsuikuTeishiOndos[$generation];
        if ($chakabunaiOndo >= $hatsuikuTeishiOndo) {
            return 0;
        }

        $hiatariYukoOndo = ($chakabunaiOndo - $hatsuikuZeroTens[$generation]) / 24;

        if ($hiatariYukoOndo > 0) {
            return $hiatariYukoOndo;
        }

        return 0;
    }
}
<?php

namespace KuwashiroBuster\Calculator;

use KuwashiroBuster\Kuwashiro\KuwashiroInterface;

interface CalculatorInterface
{
    /**
     * 茶株内温度を計算する
     *
     * @param $kion
     * @param $coverType
     * @return mixed
     */
    public function calcChakabunaiOndo($kion, $coverType);

    /**
     * 日当たり有効温度を返す
     *
     * @param $chakabunaiOndo float 茶株内温度
     * @param KuwashiroInterface $kuwashiro
     * @return float
     */
    public function calcHiatariYukoOndo($chakabunaiOndo, KuwashiroInterface $kuwashiro);
}
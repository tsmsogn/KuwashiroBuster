<?php

namespace KuwashiroBuster\Calculator;

use KuwashiroBuster\Kuwashiro\FarmInterface;
use KuwashiroBuster\Kuwashiro\KuwashiroInterface;

interface CalculatorInterface
{
    public function calcChakabunaiOndo($kion, FarmInterface $coverType);

    /**
     * 日当たり有効温度を返す
     *
     * @param $chakabunaiOndo float 茶株内温度
     * @param KuwashiroInterface $kuwashiro
     * @return float
     */
    public function calcHiatariYukoOndo($chakabunaiOndo, KuwashiroInterface $kuwashiro);
}
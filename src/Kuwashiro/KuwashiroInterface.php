<?php

namespace KuwashiroBuster\Kuwashiro;


interface KuwashiroInterface
{
    /**
     * 世代を返す
     *
     * @return int 世代
     */
    public function getGeneration();

    /**
     * 孵化したを返す
     *
     * @return boolean
     */
    public function isHatch();

    /**
     * 発育零点を返す
     *
     * @return float
     */
    public function getMinDevelopThresholdTemperature();

    /**
     * 発育停止点を返す
     *
     * @return float
     */
    public function getMaxDevelopThresholdTemperature();

    /**
     * 起算日を過ぎているかを返す
     *
     * @return boolean
     */
    public function isStarted();

    /**
     * 茶株内温度を加えて、育てる
     *
     * @param float $temperature 茶株内温度
     */
    public function grow($temperature);

    /**
     * 現在の有効積算温度を返す
     *
     * @return float
     */
    public function getCurrentDevelopTemperature();

    /**
     * 有効積算温度を返す
     *
     * @return float
     */
    public function getDevelopTemperature();
}
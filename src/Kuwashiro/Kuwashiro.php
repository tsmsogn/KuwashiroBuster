<?php

namespace KuwashiroBuster\Kuwashiro;

class Kuwashiro implements KuwashiroInterface
{
    protected $_defaultCalculator = '\\KuwashiroBuster\\Calculator\\Calculator';

    protected $_calculator;

    CONST GENERATION_1 = 1;
    CONST GENERATION_2 = 2;
    CONST GENERATION_3 = 3;

    /**
     * @var bool
     */
    public $started;

    /**
     * @var int 世代
     */
    protected $_generation;

    /**
     * @var int 現在の有効積算温度
     */
    protected $_currentDevelopmentTemperature;

    /**
     * 世代ごとの有効積算温度
     *
     * @var array
     */
    protected $_developThresholdTemperatureMap = [
        self::GENERATION_1 => 287,
        self::GENERATION_2 => 688,
        self::GENERATION_3 => 688
    ];

    /**
     * 世代ごとの発育ゼロ点
     *
     * @var array
     */
    protected $_minDevelopThresholdTemperatureMap = [
        self::GENERATION_1 => 10.5,
        self::GENERATION_2 => 10.8,
        self::GENERATION_3 => 10.8,
    ];

    /**
     * 世代ごとの発育ゼロ点
     *
     * @var array
     */
    protected $_maxDevelopThresholdTemperatureMap = [
        self::GENERATION_1 => INF,
        self::GENERATION_2 => 30,
        self::GENERATION_3 => 30,
    ];

    /**
     * Kuwashiro constructor.
     * @param $generation int 世代
     */
    public function __construct($generation)
    {
        if (!in_array($generation, self::getAvailableGenerations())) {
            throw new \InvalidArgumentException();
        }
        $this->_generation = $generation;
        $this->_currentDevelopmentTemperature = 0;
        $this->started = false;

        $this->calculator(new $this->_defaultCalculator);
    }

    /**
     * @return array
     */
    public static function getAvailableGenerations()
    {
        return array(self::GENERATION_1, self::GENERATION_2, self::GENERATION_3);
    }

    /**
     * どの世代か返す
     *
     * @return mixed
     */
    public function getGeneration()
    {
        return $this->_generation;
    }

    /**
     * 孵化したかを返す
     *
     * @return bool
     */
    public function isHatch()
    {
        return $this->getDevelopTemperature() < $this->getCurrentDevelopTemperature();
    }

    /**
     * 発育零点を返す
     *
     * @return float
     */
    public function getMinDevelopThresholdTemperature()
    {
        return $this->_minDevelopThresholdTemperatureMap[$this->getGeneration()];
    }

    /**
     * 発育停止点を返す
     *
     * @return float
     */
    public function getMaxDevelopThresholdTemperature()
    {
        return $this->_maxDevelopThresholdTemperatureMap[$this->getGeneration()];
    }

    /**
     * 起算日を過ぎているかを返す
     *
     * @return boolean
     */
    public function isStarted()
    {
        return $this->started;
    }

    /**
     * 茶株内温度を加えて、育てる
     *
     * @param float $temperature 茶株内温度
     */
    public function grow($temperature)
    {
        if (!$this->isStarted()) {
            return;
        }

        $this->_currentDevelopmentTemperature += $this->calculator()->calcHiatariYukoOndo($temperature, $this);
    }

    /**
     * 現在の有効積算温度を返す
     *
     * @return float
     */
    public function getCurrentDevelopTemperature()
    {
        return $this->_currentDevelopmentTemperature;
    }

    /**
     * 有効積算温度を返す
     *
     * @return float
     */
    public function getDevelopTemperature()
    {
        return $this->_developThresholdTemperatureMap[$this->getGeneration()];
    }

    /**
     * @param $enabled
     */
    public function enableStarted($enabled = true)
    {
        $this->started = $enabled;
    }

    /**
     * @param \KuwashiroBuster\Calculator\CalculatorInterface|null $calculator
     * @return \KuwashiroBuster\Calculator\CalculatorInterface
     */
    public function calculator(\KuwashiroBuster\Calculator\CalculatorInterface $calculator = null)
    {
        if (!$this->_calculator instanceof \KuwashiroBuster\Calculator\CalculatorInterface) {
            $this->_calculator = $calculator;
        }

        return $this->_calculator;
    }
}
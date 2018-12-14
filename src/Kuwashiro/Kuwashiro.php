<?php

namespace KuwashiroBuster\Kuwashiro;

class Kuwashiro implements KuwashiroInterface
{
    protected $_defaultCalculator = '\\KuwashiroBuster\\Calculator\\Calculator';

    protected $_calculator;

    CONST SEDAI_1 = 1;
    CONST SEDAI_2 = 2;
    CONST SEDAI_3 = 3;

    /**
     * @var bool
     */
    public $started;

    /**
     * @var int 世代
     */
    protected $_generation;
    protected $_yukoSekisanOndo;

    /**
     * 世代ごとの有効積算温度
     *
     * @var array
     */
    protected $_developThresholdTemperatureMap = [
        self::SEDAI_1 => 287,
        self::SEDAI_2 => 688,
        self::SEDAI_3 => 688
    ];

    /**
     * 世代ごとの発育ゼロ点
     *
     * @var array
     */
    protected $_minDevelopThresholdTemperatureMap = [
        self::SEDAI_1 => 10.5,
        self::SEDAI_2 => 10.8,
        self::SEDAI_3 => 10.8,
    ];

    /**
     * 世代ごとの発育ゼロ点
     *
     * @var array
     */
    protected $_maxDevelopThresholdTemperatureMap = [
        self::SEDAI_1 => INF,
        self::SEDAI_2 => 30,
        self::SEDAI_3 => 30,
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
        $this->_yukoSekisanOndo = 0;
        $this->started = false;

        $this->calculator(new $this->_defaultCalculator);
    }

    /**
     * @return array
     */
    public static function getAvailableGenerations()
    {
        return array(self::SEDAI_1, self::SEDAI_2, self::SEDAI_3);
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
     * @param float $temperature 茶株内温度
     */
    public function grow($temperature)
    {
        if (!$this->isStarted()) {
            return;
        }

        $this->_yukoSekisanOndo += $this->calculator()->calcHiatariYukoOndo($temperature, $this);
    }

    /**
     * 現在の有効積算温度を返す
     *
     * @return float
     */
    public function getCurrentDevelopTemperature()
    {
        return $this->_yukoSekisanOndo;
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
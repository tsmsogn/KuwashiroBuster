<?php

namespace KuwashiroBuster\Kuwashiro;

use KuwashiroBuster\Constraints\CoverType;
use KuwashiroBuster\Constraints\Generation;
use KuwashiroBuster\Processor\ProcessorInterface;

class Kuwashiro implements KuwashiroInterface
{
    /**
     * @var string
     */
    protected $defaultProcessor = '\\KuwashiroBuster\\Processor\\Processor';

    /**
     * @var ProcessorInterface
     */
    protected $processor;

    /**
     * @var int
     */
    public $coverType;

    /**
     * @var bool
     */
    public $sekisanEnabled;

    /**
     * @var int 世代
     */
    protected $generation;

    /**
     * @var int 現在の有効積算温度
     */
    protected $currentYukoSekisanOndo;

    /**
     * 世代ごとの有効積算温度
     *
     * @var array
     */
    protected $yukoSekisanOndoMap = array(
        Generation::GENERATION_1 => 287,
        Generation::GENERATION_2 => 688,
        Generation::GENERATION_3 => 688
    );

    /**
     * 世代ごとの発育ゼロ点
     *
     * @var array
     */
    protected $hatsuikuZeroTenMap = array(
        Generation::GENERATION_1 => 10.5,
        Generation::GENERATION_2 => 10.8,
        Generation::GENERATION_3 => 10.8,
    );

    /**
     * 世代ごとの発育停止温度
     *
     * @var array
     */
    protected $hatsuikuTeishiOndoMap = array(
        Generation::GENERATION_1 => INF,
        Generation::GENERATION_2 => 30,
        Generation::GENERATION_3 => 30,
    );

    /**
     * Kuwashiro constructor.
     * @param $generation
     * @param bool $sekisanEnabled
     */
    public function __construct($generation, $sekisanEnabled = true)
    {
        if (!in_array($generation, Generation::getList())) {
            throw new \InvalidArgumentException();
        }
        $this->generation = $generation;
        $this->currentYukoSekisanOndo = 0;
        $this->sekisanEnabled = $sekisanEnabled;

        $this->coverType = CoverType::ROTEN;

        $this->processor(new $this->defaultProcessor);
    }

    /**
     * 世代を返す
     *
     * @return mixed
     */
    public function getGeneration()
    {
        return $this->generation;
    }

    /**
     * 孵化したかを返す
     *
     * @return bool
     */
    public function isHatch()
    {
        return $this->getYukoSekisanOndo() < $this->getCurrentYukioSekisanOndo();
    }

    /**
     * 発育零点を返す
     *
     * @return float
     */
    public function getHatsuikuZeroTen()
    {
        return $this->hatsuikuZeroTenMap[$this->getGeneration()];
    }

    /**
     * 発育停止温度を返す
     *
     * @return float
     */
    public function getHatsuikuTeishiOndo()
    {
        return $this->hatsuikuTeishiOndoMap[$this->getGeneration()];
    }

    /**
     * 積算が有効化されているかを返す
     *
     * @return boolean
     */
    public function isSekisanEnabled()
    {
        return $this->sekisanEnabled;
    }

    /**
     * 気温で育つ
     *
     * @param $temperature
     * @return $this
     */
    public function grow($temperature)
    {
        if ($this->isSekisanEnabled()) {
            $chakabuOndo = $this->processor()->toChakabunaiOndo($temperature, $this->getCoverType());
            $this->currentYukoSekisanOndo += $this->processor()->toYukoSekisanOndo($chakabuOndo, $this->getGeneration());
        }

        return $this;
    }

    /**
     * 現在の有効積算温度を返す
     *
     * @return float
     */
    public function getCurrentYukioSekisanOndo()
    {
        return $this->currentYukoSekisanOndo;
    }

    /**
     * 有効積算温度を返す
     *
     * @return float
     */
    public function getYukoSekisanOndo()
    {
        return $this->yukoSekisanOndoMap[$this->getGeneration()];
    }

    /**
     * 積算を有効化する
     *
     * @param bool $enabled
     * @return $this
     */
    public function enableSekisan($enabled = true)
    {
        $this->sekisanEnabled = $enabled;
        return $this;
    }

    /**
     * @param \KuwashiroBuster\Processor\ProcessorInterface|null $processor
     * @return \KuwashiroBuster\Processor\ProcessorInterface
     */
    protected function processor(\KuwashiroBuster\Processor\ProcessorInterface $processor = null)
    {
        if (!$this->processor instanceof \KuwashiroBuster\Processor\ProcessorInterface) {
            $this->processor = $processor;
        }

        return $this->processor;
    }

    /**
     * 被覆タイプを返す
     *
     * @return int
     */
    public function getCoverType()
    {
        return $this->coverType;
    }

    /**
     * 被覆タイプを設定する
     *
     * @param $coverType
     * @return $this
     */
    public function setCoverType($coverType)
    {
        $this->coverType = $coverType;
        return $this;
    }
}
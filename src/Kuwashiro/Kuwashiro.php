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
    public $yukoSekisanOndoEnabled;

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
     * @param bool $yukoSekisanOndoEnabled
     */
    public function __construct($generation, $yukoSekisanOndoEnabled = true)
    {
        if (!in_array($generation, Generation::getList())) {
            throw new \InvalidArgumentException();
        }
        $this->generation = $generation;
        $this->currentYukoSekisanOndo = 0;
        $this->yukoSekisanOndoEnabled = $yukoSekisanOndoEnabled;

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
    public function isYukoSekisanOndoEnabled()
    {
        return $this->yukoSekisanOndoEnabled;
    }

    /**
     * 気温で育つ
     *
     * @param $temperature
     */
    public function grow($temperature)
    {
        if (!$this->isYukoSekisanOndoEnabled()) {
            return;
        }

        $chakabuOndo = $this->processor()->toChakabunaiOndo($temperature, $this->getCoverType());
        $this->currentYukoSekisanOndo += $this->processor()->toYukoSekisanOndo($chakabuOndo, $this->getGeneration());
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
     * @param $enabled
     */
    public function enableYukoSekisanOndo($enabled = true)
    {
        $this->yukoSekisanOndoEnabled = $enabled;
    }

    /**
     * @param \KuwashiroBuster\Processor\ProcessorInterface|null $processor
     * @return \KuwashiroBuster\Processor\ProcessorInterface
     */
    public function processor(\KuwashiroBuster\Processor\ProcessorInterface $processor = null)
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
     */
    public function setCoverType($coverType)
    {
        $this->coverType = $coverType;
    }
}
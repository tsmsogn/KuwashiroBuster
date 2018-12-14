<?php

namespace KuwashiroBuster\Test;

use KuwashiroBuster\Kuwashiro\Kuwashiro;
use PHPUnit\Framework\TestCase;

class KuwashiroTest extends TestCase
{
    /**
     * @var Kuwashiro
     */
    public $kuwashiro;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        $this->kuwashiro = new Kuwashiro(Kuwashiro::GENERATION_1);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->kuwashiro);
    }

    /**
     * @return void
     */
    public function testGetDevelopThresholdTemperature()
    {
        $this->assertEquals(287, (new Kuwashiro(Kuwashiro::GENERATION_1))->getDevelopTemperature());
        $this->assertEquals(688, (new Kuwashiro(Kuwashiro::GENERATION_2))->getDevelopTemperature());
        $this->assertEquals(688, (new Kuwashiro(Kuwashiro::GENERATION_3))->getDevelopTemperature());
    }

    /**
     * @return void
     */
    public function testGetMinDevelopThresholdTemperature()
    {
        $this->assertEquals(10.5, (new Kuwashiro(Kuwashiro::GENERATION_1))->getMinDevelopThresholdTemperature());
        $this->assertEquals(10.8, (new Kuwashiro(Kuwashiro::GENERATION_2))->getMinDevelopThresholdTemperature());
        $this->assertEquals(10.8, (new Kuwashiro(Kuwashiro::GENERATION_3))->getMinDevelopThresholdTemperature());
    }

    /**
     * @return void
     */
    public function testGetMaxDevelopThresholdTemperature()
    {
        $this->assertEquals(INF, (new Kuwashiro(Kuwashiro::GENERATION_1))->getMaxDevelopThresholdTemperature());
        $this->assertEquals(30, (new Kuwashiro(Kuwashiro::GENERATION_2))->getMaxDevelopThresholdTemperature());
        $this->assertEquals(30, (new Kuwashiro(Kuwashiro::GENERATION_3))->getMaxDevelopThresholdTemperature());
    }

    /**
     * @return void
     */
    public function testGetGenerationType()
    {
        $this->assertEquals(1, $this->kuwashiro->getGeneration());
    }

    /**
     * @return void
     */
    public function testYukoSekisanOndo()
    {
        $this->assertFalse($this->kuwashiro->isHatch());
        $this->kuwashiro->enableStarted();

        while (!$this->kuwashiro->isHatch()) {
            $this->kuwashiro->grow(20);
        }

        $this->assertNotEquals(0, $this->kuwashiro->getCurrentDevelopTemperature());
        $this->assertTrue($this->kuwashiro->isHatch());
    }

    /**
     * @return void
     */
    public function testGrow()
    {
        $kuwashiro = new Kuwashiro(Kuwashiro::GENERATION_1);
        $kuwashiro->enableStarted(true);
        $kuwashiro->grow(20);

        $this->assertNotEquals(0, $kuwashiro->getCurrentDevelopTemperature());
    }

    /**
     * @return void
     */
    public function testGrowWithNotStarted()
    {
        $kuwashiro = new Kuwashiro(Kuwashiro::GENERATION_1);
        $kuwashiro->grow(1);

        $this->assertEquals(0, $kuwashiro->getCurrentDevelopTemperature());
    }

    /**
     * @return void
     */
    public function testGrowWithNegative()
    {
        $kuwashiro = new Kuwashiro(Kuwashiro::GENERATION_1);
        $kuwashiro->enableStarted();
        $kuwashiro->grow(-1);

        $this->assertEquals(0, $kuwashiro->getCurrentDevelopTemperature());
    }
}

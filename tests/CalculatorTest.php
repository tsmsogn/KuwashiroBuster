<?php

namespace KuwashiroBuster\Test;

use KuwashiroBuster\Calculator\Calculator;
use KuwashiroBuster\Calculator\CoverType;
use KuwashiroBuster\Kuwashiro\Farm;
use KuwashiroBuster\Kuwashiro\Kuwashiro;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{

    /**
     * @var \KuwashiroBuster\Calculator\CalculatorInterface
     */
    public $calculator;

    public function setUp()
    {
        parent::setUp();

        $this->calculator = new Calculator();
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->calculator);
    }

    /**
     * testCalcChakabunaiOndo
     *
     * @return void
     */
    public function testCalcChakabunaiOndo()
    {
        $this->assertEquals(1.6977, $this->calculator->calcChakabunaiOndo(2, Farm::TUZYO));
        $this->assertEquals(2.826, $this->calculator->calcChakabunaiOndo(2, Farm::HIFUKU1));
        $this->assertEquals(3.6579, $this->calculator->calcChakabunaiOndo(2, Farm::HIFUKU2));
        $this->assertEquals(-0.8333, $this->calculator->calcChakabunaiOndo(2, Farm::BANGARICYOKUGO));
    }

    /**
     * testCalcHiatariYukoOndo
     *
     * @return void
     */
    public function testCalcHiatariYukoOndo()
    {
        $this->assertEquals(0, $this->calculator->calcHiatariYukoOndo(0, Kuwashiro::GENERATION_1));
        $this->assertEquals(1, $this->calculator->calcHiatariYukoOndo(34.5, Kuwashiro::GENERATION_1));

        $this->assertEquals(0, $this->calculator->calcHiatariYukoOndo(0, Kuwashiro::GENERATION_2));
        $this->assertEquals(0.5, $this->calculator->calcHiatariYukoOndo(22.8, Kuwashiro::GENERATION_2));
        $this->assertEquals(0, $this->calculator->calcHiatariYukoOndo(30, Kuwashiro::GENERATION_2));

        $this->assertEquals(0, $this->calculator->calcHiatariYukoOndo(0, Kuwashiro::GENERATION_3));
        $this->assertEquals(0.5, $this->calculator->calcHiatariYukoOndo(22.8, Kuwashiro::GENERATION_3));
        $this->assertEquals(0, $this->calculator->calcHiatariYukoOndo(30, Kuwashiro::GENERATION_3));
    }
}

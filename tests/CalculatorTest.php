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
        $this->assertEquals(1.6977, $this->calculator->calcChakabunaiOndo(2, new Farm(Farm::TUZYO)));
        $this->assertEquals(2.826, $this->calculator->calcChakabunaiOndo(2, new Farm(Farm::HIFUKU1)));
        $this->assertEquals(3.6579, $this->calculator->calcChakabunaiOndo(2, new Farm(Farm::HIFUKU2)));
        $this->assertEquals(-0.8333, $this->calculator->calcChakabunaiOndo(2, new Farm(Farm::BANGARICYOKUGO)));
    }

    /**
     * testCalcHiatariYukoOndo
     *
     * @return void
     */
    public function testCalcHiatariYukoOndo()
    {
        $generation1 = new Kuwashiro(Kuwashiro::GENERATION_1);
        $generation2 = new Kuwashiro(Kuwashiro::GENERATION_2);
        $generation3 = new Kuwashiro(Kuwashiro::GENERATION_3);

        $this->assertEquals(0, $this->calculator->calcHiatariYukoOndo(0, $generation1));
        $this->assertEquals(1, $this->calculator->calcHiatariYukoOndo(34.5, $generation1));

        $this->assertEquals(0, $this->calculator->calcHiatariYukoOndo(0, $generation2));
        $this->assertEquals(0.5, $this->calculator->calcHiatariYukoOndo(22.8, $generation2));
        $this->assertEquals(0, $this->calculator->calcHiatariYukoOndo(30, $generation2));

        $this->assertEquals(0, $this->calculator->calcHiatariYukoOndo(0, $generation3));
        $this->assertEquals(0.5, $this->calculator->calcHiatariYukoOndo(22.8, $generation3));
        $this->assertEquals(0, $this->calculator->calcHiatariYukoOndo(30, $generation3));
    }
}

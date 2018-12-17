<?php

namespace KuwashiroBuster\Test;

use KuwashiroBuster\Constraints\Generation;
use KuwashiroBuster\Processor\Processor;
use KuwashiroBuster\Constraints\CoverType;
use PHPUnit\Framework\TestCase;

class ProcessorTest extends TestCase
{
    /**
     * @var \KuwashiroBuster\Processor\ProcessorInterface
     */
    public $processor;

    public function setUp()
    {
        parent::setUp();

        $this->processor = new Processor();
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->processor);
    }

    /**
     * @return void
     */
    public function testToChakabunaiOndo()
    {
        $this->assertEquals(1.6977, $this->processor->toChakabunaiOndo(2, CoverType::ROTEN));
        $this->assertEquals(2.826, $this->processor->toChakabunaiOndo(2, CoverType::HITIE_HIFUKU));
        $this->assertEquals(3.6579, $this->processor->toChakabunaiOndo(2, CoverType::FUTAE_HIFUKU));
        $this->assertEquals(-0.8333, $this->processor->toChakabunaiOndo(2, CoverType::BANGARI));
    }

    /**
     * @return void
     */
    public function testToYukoSekisanOndo()
    {
        $this->assertEquals(0, $this->processor->toHiatariYukoOndo(0, Generation::GENERATION_1));
        $this->assertEquals(1, $this->processor->toHiatariYukoOndo(34.5, Generation::GENERATION_1));

        $this->assertEquals(0, $this->processor->toHiatariYukoOndo(0, Generation::GENERATION_2));
        $this->assertEquals(0.5, $this->processor->toHiatariYukoOndo(22.8, Generation::GENERATION_2));
        $this->assertEquals(0, $this->processor->toHiatariYukoOndo(30, Generation::GENERATION_2));

        $this->assertEquals(0, $this->processor->toHiatariYukoOndo(0, Generation::GENERATION_3));
        $this->assertEquals(0.5, $this->processor->toHiatariYukoOndo(22.8, Generation::GENERATION_3));
        $this->assertEquals(0, $this->processor->toHiatariYukoOndo(30, Generation::GENERATION_3));
    }
}

<?php

namespace KuwashiroBuster\Test;

use KuwashiroBuster\Constraints\CoverType;
use KuwashiroBuster\Constraints\Generation;
use KuwashiroBuster\Kuwashiro\Kuwashiro;
use PHPUnit\Framework\TestCase;

class KuwashiroTest extends TestCase
{
    /**
     * @var \KuwashiroBuster\Kuwashiro\Kuwashiro
     */
    public $kuwashiro;

    public function setUp()
    {
        parent::setUp();

        $this->kuwashiro = new Kuwashiro(Generation::GENERATION_1);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->kuwashiro);
    }

    /**
     * @return void
     */
    public function testConstructor()
    {
        $this->assertEquals(0, $this->kuwashiro->getCurrentYukioSekisanOndo());
        $this->assertEquals(CoverType::ROTEN, $this->kuwashiro->getCoverType());
        $this->assertEquals(Generation::GENERATION_1, $this->kuwashiro->getCoverType());
        $this->assertTrue($this->kuwashiro->isSekisanEnabled());
    }

    /**
     * @return void
     */
    public function testConstructorWithInvalidArgument()
    {
        $this->setExpectedException('InvalidArgumentException');

        new Kuwashiro(0);
    }

    /**
     * @return void
     */
    public function testGetYukoSekisanOndo()
    {
        $generation1 = new Kuwashiro(Generation::GENERATION_1);
        $this->assertEquals(287, $generation1->getYukoSekisanOndo());

        $generation2 = new Kuwashiro(Generation::GENERATION_2);
        $this->assertEquals(688, $generation2->getYukoSekisanOndo());

        $generation3 = new Kuwashiro(Generation::GENERATION_3);
        $this->assertEquals(688, $generation3->getYukoSekisanOndo());
    }

    /**
     * @return void
     */
    public function testGetHatsuikuZeroTen()
    {
        $generation1 = new Kuwashiro(Generation::GENERATION_1);
        $this->assertEquals(10.5, $generation1->getHatsuikuZeroTen());

        $generation2 = new Kuwashiro(Generation::GENERATION_2);
        $this->assertEquals(10.8, $generation2->getHatsuikuZeroTen());

        $generation3 = new Kuwashiro(Generation::GENERATION_3);
        $this->assertEquals(10.8, $generation3->getHatsuikuZeroTen());
    }

    /**
     * @return void
     */
    public function testGetHatsuikuTeishiOndo()
    {
        $generation1 = new Kuwashiro(Generation::GENERATION_1);
        $this->assertEquals(INF, $generation1->getHatsuikuTeishiOndo());

        $generation2 = new Kuwashiro(Generation::GENERATION_2);
        $this->assertEquals(30, $generation2->getHatsuikuTeishiOndo());

        $generation3 = new Kuwashiro(Generation::GENERATION_3);
        $this->assertEquals(30, $generation3->getHatsuikuTeishiOndo());
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

        while (!$this->kuwashiro->isHatch()) {
            $this->kuwashiro->grow(20);
        }

        $this->assertNotEquals(0, $this->kuwashiro->getCurrentYukioSekisanOndo());
        $this->assertTrue($this->kuwashiro->isHatch());
    }

    /**
     * @return void
     */
    public function testGrow()
    {
        $currentYukoSekisanOndo = $this->kuwashiro
            ->grow(20)
            ->getCurrentYukioSekisanOndo();

        $this->assertNotEquals(0, $currentYukoSekisanOndo);
    }

    /**
     * @return void
     */
    public function testGrowWithSekisanDisabled()
    {
        $currentYukoSekisanOndo = $this->kuwashiro
            ->enableSekisan(false)
            ->grow(20)
            ->getCurrentYukioSekisanOndo();

        $this->assertEquals(0, $currentYukoSekisanOndo);
    }

    /**
     * @return void
     */
    public function testGrowWithNegative()
    {
        $currentYukoSekisanOndo = $this->kuwashiro
            ->grow(-1)
            ->getCurrentYukioSekisanOndo();

        $this->assertEquals(0, $currentYukoSekisanOndo);
    }

    /**
     * @return void
     */
    public function testEnableSekisan()
    {
        $this->assertFalse($this->kuwashiro->enableSekisan(false)->isSekisanEnabled());
    }

    /**
     * @return void
     */
    public function testCoverType()
    {
        $coverType = $this->kuwashiro
            ->setCoverType(CoverType::BANGARI)
            ->getCoverType();

        $this->assertEquals(CoverType::BANGARI, $coverType);
    }
}

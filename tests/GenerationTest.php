<?php

namespace KuwashiroBuster\Test;

use KuwashiroBuster\Constraints\Generation;
use PHPUnit\Framework\TestCase;

class GenerationTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetList()
    {
        $this->assertCount(3, Generation::getList());
    }
}

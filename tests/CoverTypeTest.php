<?php

namespace KuwashiroBuster\Test;

use KuwashiroBuster\Constraints\CoverType;
use PHPUnit\Framework\TestCase;

class CoverTypeTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetList()
    {
        $this->assertCount(4, CoverType::getList());
    }
}

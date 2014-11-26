<?php

namespace test\LoveSay;

use LoveSay\Originator;

class OriginatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canBeInstantiated()
    {
        $originator = new Originator('name');
        $this->assertInstanceOf('\LoveSay\Originator', $originator);
    }

    /**
     * @test
     */
    public function mustHaveIdentifier()
    {
        $this->setExpectedException('\InvalidArgumentException');
        new Originator(null);
    }

    /**
     * @test
     */
    public function keyIsChecksum()
    {
        $originator = new Originator('name');
        $this->assertEquals(Originator::checksum('name'), $originator->getKey());
    }


}
 
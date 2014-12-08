<?php

namespace test\LoveSay;

use LoveSay\Note;
use LoveSay\Relationship;

class NoteTest extends \PHPUnit_Framework_TestCase
{
    /** @var Note */
    private $note;
    /** @var Relationship | \PHPUnit_Framework_MockObject_MockObject */
    private $relationship;

    public function setup()
    {
        $this->relationship = $this->getMockBuilder('\LoveSay\Relationship')
            ->disableOriginalConstructor()
            ->getMock();
        $this->relationship->method('getKey')
            ->willReturn(11);
    }

    /**
     * @test
     */
    public function canBeInstantiated()
    {
        $note = new Note($this->relationship->getKey(), '');
        $this->assertInstanceOf('\LoveSay\Note', $note);
    }

    /**
     * @test
     */
    public function canGetText()
    {
        $this->expectNote('test note');
        $this->assertEquals('test note', $this->note->getMessage());
    }

    /**
     * @test
     */
    public function keyIsChecksum()
    {
        $this->expectNote('test');
        $this->assertEquals(Note::computeChecksum('test' . $this->relationship->getKey()), $this->note->getKey());
    }

    /** Expectations **************************************************** */

    /**
     * @param $message
     */
    private function expectNote($message)
    {
        $this->note = new Note($this->relationship->getKey(), $message);
    }
}
 
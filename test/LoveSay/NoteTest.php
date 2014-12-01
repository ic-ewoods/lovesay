<?php

namespace test\LoveSay;

use LoveSay\Note;
use LoveSay\Originator;

class NoteTest extends \PHPUnit_Framework_TestCase
{
    /** @var Note */
    private $note;
    /** @var Originator | \PHPUnit_Framework_MockObject_MockObject */
    private $originator;

    public function setup()
    {
        $this->originator = $this->getMockBuilder('\LoveSay\Originator')
            ->disableOriginalConstructor()
            ->getMock();
        $this->originator->method('getKey')
            ->willReturn(1);
    }

    /**
     * @test
     */
    public function canBeInstantiated()
    {
        $note = new Note($this->originator->getKey(), '');
        $this->assertInstanceOf('\LoveSay\Note', $note);
    }

    /**
     * @test
     */
    public function canGetText()
    {
        $this->expectNote('test note');
        $this->assertEquals('test note', $this->note->getText());
    }

    /**
     * @test
     */
    public function keyIsChecksum()
    {
        $this->expectNote('test');
        $this->assertEquals(Note::checksum('test' . 1), $this->note->getKey());
    }

    /** Expectations **************************************************** */

    private function expectNote($text)
    {
        $this->note = new Note($this->originator->getKey(), $text);
    }
}
 
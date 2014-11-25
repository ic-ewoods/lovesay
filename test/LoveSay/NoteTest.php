<?php

namespace test\LoveSay;

use LoveSay\Note;

class NoteTest extends \PHPUnit_Framework_TestCase
{
    /** @var Note */
    private $note;

    /**
     * @test
     */
    public function canBeInstantiated()
    {
        $note = new Note('');
        $this->assertInstanceOf('\LoveSay\Note', $note);
    }

    /**
     * @test
     */
    public function canReturnNoteText()
    {
        $this->expectNote('test note');
        $this->assertEquals('test note', $this->note->getText());
    }

    private function expectNote($text)
    {
        $this->note = new Note($text);
    }
}
 
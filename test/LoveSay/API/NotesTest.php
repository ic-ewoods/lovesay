<?php

namespace test\LoveSay\API;

use LoveSay\API\Notes;
use LoveSay\Note;
use LoveSay\Originator;
use LoveSay\Persistence\Sqlite\SqliteNotesStorage;

class NotesTest extends \PHPUnit_Framework_TestCase
{

    /** @var Notes */
    private $notes_api;

    /** @var Originator | \PHPUnit_Framework_MockObject_MockObject */
    private $originator;

    /** @var SqliteNotesStorage | \PHPUnit_Framework_MockObject_MockObject */
    private $storage;

    /**
     *
     */
    public function setup()
    {
        $this->originator = $this->getMockBuilder('\LoveSay\Originator')
            ->disableOriginalConstructor()
            ->getMock();
        $this->originator->method('getKey')
            ->willReturn(1);
        $this->storage = $this->getMockBuilder('\LoveSay\Persistence\NotesStorage')
            ->disableOriginalConstructor()
            ->getMock();

        $this->notes_api = new Notes($this->originator, new SqliteNotesStorage());
    }

    /**
     * @test
     */
    public function canBeInstantiated()
    {
        $notes_api = new Notes($this->originator, $this->storage);
        $this->assertInstanceOf('\LoveSay\API\Notes', $notes_api);
    }

    /**
     * @test
     */
    public function canGetCount()
    {
        $this->expectTwoNotes();
        $this->assertEquals(2, $this->notes_api->getNoteCount());
    }

    /**
     * @test
     */
    public function canAddNote()
    {
        $this->expectTwoNotes();
        $note = new Note($this->originator->getKey(), 'Thing Three?');

        $this->assertEquals(2, $this->notes_api->getNoteCount());

        $this->notes_api->putNote($note);
        $this->assertEquals(3, $this->notes_api->getNoteCount());
    }

    /**
     * @test
     */
    public function canGetNote()
    {
        $this->expectTwoNotes();
        $note_key = Note::checksum("Thing One" . 1);
        $this->assertInstanceOf('\LoveSay\Note', $this->notes_api->getNote($note_key));
    }

    /**
     * @test
     */
    public function canGetAllNotes()
    {
        $this->expectTwoNotes();
        $notes = $this->notes_api->getAllNotes();
        $this->assertEquals(2, $notes->count());
    }

    /** Expectations **************************************************** */

    public function expectTwoNotes()
    {
        $say = array(
            "Thing One",
            "Thing Two"
        );
        $this->notes_api->importFromArray($say);
    }

}
 
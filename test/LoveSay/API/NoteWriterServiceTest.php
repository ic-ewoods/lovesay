<?php

namespace test\LoveSay\API;

use LoveSay\API\NoteWriterService;
use LoveSay\Freshness\Any;
use LoveSay\Note;
use LoveSay\Originator;
use LoveSay\Persistence\Sqlite\SqliteNotesStorage;

class NoteWriterServiceTest extends \PHPUnit_Framework_TestCase
{

    /** @var NoteWriterService */
    private $note_writer_api;

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

        $this->note_writer_api = new NoteWriterService($this->originator, new SqliteNotesStorage());
    }

    /**
     * @test
     */
    public function canBeInstantiated()
    {
        $notes_api = new NoteWriterService($this->originator, $this->storage);
        $this->assertInstanceOf('\LoveSay\API\NoteWriterService', $notes_api);
    }

    /**
     * @test
     */
    public function canGetCount()
    {
        $this->expectTwoNotes();
        $this->assertEquals(2, $this->note_writer_api->getCount());
    }

    /**
     * @test
     */
    public function canAddNote()
    {
        $this->expectTwoNotes();
        $note = new Note($this->originator->getKey(), 'Thing Three?');

        $this->assertEquals(2, $this->note_writer_api->getCount());

        $this->note_writer_api->putNote($note);
        $this->assertEquals(3, $this->note_writer_api->getCount());
    }

    /**
     * @test
     */
    public function canGetNote()
    {
        $this->expectTwoNotes();
        $note_key = Note::checksum("Thing One" . 1);
        $this->assertInstanceOf('\LoveSay\Note', $this->note_writer_api->getNote($note_key));
    }

    /**
     * @test
     */
    public function canGetAllNotes()
    {
        $this->expectTwoNotes();
        $notes = $this->note_writer_api->getAllNotes();
        $this->assertEquals(2, $notes->count());
    }


    /** Expectations **************************************************** */

    public function expectTwoNotes()
    {
        $messages = array(
            "Thing One",
            "Thing Two"
        );
        $this->note_writer_api->importFromArray($messages);
    }

}
 
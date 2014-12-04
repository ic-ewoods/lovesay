<?php

namespace test\LoveSay\API;

use LoveSay\API\NoteReaderService;
use LoveSay\API\NoteWriterService;
use LoveSay\Freshness\Any;
use LoveSay\Note;
use LoveSay\Originator;
use LoveSay\Persistence\Sqlite\SqliteNotesStorage;
use LoveSay\Recipient;

class NoteReaderServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var NoteReaderService */
    private $note_reader_api;

    /** @var NoteWriterService */
    private $note_writer_api;

    /** @var Recipient | \PHPUnit_Framework_MockObject_MockObject */
    private $recipient;

    /** @var Originator | \PHPUnit_Framework_MockObject_MockObject */
    private $originator;

    /** @var SqliteNotesStorage | \PHPUnit_Framework_MockObject_MockObject */
    private $storage;

    /**
     *
     */
    public function setup()
    {
        $this->recipient = $this->getMockBuilder('\LoveSay\Recipient')
            ->disableOriginalConstructor()
            ->getMock();
        $this->recipient->method('getKey')
            ->willReturn(1);
        $this->originator = $this->getMockBuilder('\LoveSay\Originator')
            ->disableOriginalConstructor()
            ->getMock();
        $this->originator->method('getKey')
            ->willReturn(1);
        $this->storage = $this->getMockBuilder('\LoveSay\Persistence\NotesStorage')
            ->disableOriginalConstructor()
            ->getMock();

        $sqliteNotesStorage = new SqliteNotesStorage();
        $this->note_writer_api = new NoteWriterService($this->originator, $sqliteNotesStorage);
        $this->note_reader_api = new NoteReaderService($this->recipient, $sqliteNotesStorage);
    }

    /**
     * @test
     */
    public function canGetNote()
    {
        $this->expectTwoNotes();
        $note_key = Note::checksum("Thing One" . 1);
        $note = $this->note_reader_api->getNote($this->originator, $note_key);
        $this->assertInstanceOf('\LoveSay\Note', $note);
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
 
<?php

namespace test\LoveSay\API;

use LoveSay\API\NoteReaderService;
use LoveSay\API\NoteWriterService;
use LoveSay\Note;
use LoveSay\Persistence\Sqlite\SqliteNotesStorage;
use LoveSay\Recipient;
use LoveSay\Relationship;

class NoteReaderServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var NoteReaderService */
    private $note_reader_api;

    /** @var NoteWriterService */
    private $note_writer_api;

    /** @var Recipient | \PHPUnit_Framework_MockObject_MockObject */
    private $relationship;

    /**
     *
     */
    public function setup()
    {
        $this->relationship = $this->mockRelationship();

        $sqliteNotesStorage = new SqliteNotesStorage();

        $this->note_writer_api = new NoteWriterService($this->relationship, $sqliteNotesStorage);
        $this->note_reader_api = new NoteReaderService($this->relationship, $sqliteNotesStorage);
    }

    /**
     * @test
     */
    public function canReadNote()
    {
        $this->expectTwoNotes();
        $note_key = Note::computeChecksum("Thing One" . $this->relationship->getKey());

        $note = $this->note_reader_api->readNote($note_key);

        $this->assertInstanceOf('\LoveSay\Note', $note);
    }

    /**
     * @test
     */
    public function readingNoteIncrementsViewCount()
    {
        $this->expectTwoNotes();
        $note_key = Note::computeChecksum("Thing One" . $this->relationship->getKey());

        $note1 = $this->note_reader_api->readNote($note_key);
        $this->assertEquals(1, $note1->getViewCount());

        $note2 = $this->note_reader_api->readNote($note_key);
        $this->assertEquals(2, $note2->getViewCount());
    }

    public function readingNonExistentNoteReturnsNull()
    {
        $note = $this->note_reader_api->readNote('0');
        $this->assertNull($note);
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


    /**
     * @return Relationship | \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockRelationship()
    {
        $relationship = $this->getMockBuilder('\LoveSay\Relationship')
            ->disableOriginalConstructor()
            ->getMock();
        $relationship->method('getKey')
            ->willReturn(11);

        return $relationship;
    }
}
 
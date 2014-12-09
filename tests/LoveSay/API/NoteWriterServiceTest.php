<?php

namespace test\LoveSay\API;

use LoveSay\API\NoteWriterService;
use LoveSay\Freshness\Any;
use LoveSay\Note;
use LoveSay\Originator;
use LoveSay\Persistence\Sqlite\SqliteNotesStorage;
use LoveSay\Relationship;

class NoteWriterServiceTest extends \PHPUnit_Framework_TestCase
{

    /** @var NoteWriterService */
    private $note_writer_api;

    /** @var Relationship | \PHPUnit_Framework_MockObject_MockObject */
    private $relationship;

    /** @var SqliteNotesStorage | \PHPUnit_Framework_MockObject_MockObject */
    private $storage;

    /**
     *
     */
    public function setup()
    {
        $this->relationship = $this->mockRelationship();
        $this->storage = $this->getMockBuilder('\LoveSay\Persistence\NotesStorage')
            ->disableOriginalConstructor()
            ->getMock();

        $this->note_writer_api = new NoteWriterService($this->relationship, new SqliteNotesStorage());
    }

    /**
     * @test
     */
    public function canBeInstantiated()
    {
        $notes_api = new NoteWriterService($this->relationship, $this->storage);
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
        $note = new Note($this->relationship->getKey(), 'Thing Three?');

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
        $note_key = Note::computeChecksum("Thing One" . $this->relationship->getKey());
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

    /**
     * @test
     */
    public function getAllNotesIncludesViewCount()
    {
        $this->expectTwoNotes();
        $first_note = $this->note_writer_api->getAllNotes()[0];
        $this->assertObjectHasAttribute('view_count', $first_note);

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
 
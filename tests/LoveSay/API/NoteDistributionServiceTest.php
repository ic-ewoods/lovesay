<?php

namespace test\LoveSay\API;

use LoveSay\API\NoteDistributionService;
use LoveSay\API\NoteWriterService;
use LoveSay\Freshness\Any;
use LoveSay\Originator;
use LoveSay\Persistence\Sqlite\SqliteNotesStorage;
use LoveSay\Recipient;
use LoveSay\Relationship;

class NoteDistributionServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var Relationship | \PHPUnit_Framework_MockObject_MockObject */
    private $relationship;

    /** @var NoteDistributionService */
    private $note_distribution_api;

    /** @var NoteWriterService */
    private $note_writer_api;

    public function setup()
    {
        $this->relationship = $this->mockRelationship();
        $this->storage = $this->getMockBuilder('\LoveSay\Persistence\NotesStorage')
            ->disableOriginalConstructor()
            ->getMock();

        $sqliteNotesStorage = new SqliteNotesStorage();
        $this->note_writer_api = new NoteWriterService($this->relationship->getKey(), $sqliteNotesStorage);

        $this->note_distribution_api = new NoteDistributionService($this->relationship->getKey(), $sqliteNotesStorage);
    }

    public function canGetNoteToDistribute()
    {
        $this->expectTwoNotes();
        $note = $this->note_distribution_api->getFreshNote($this->relationship, new Any());

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
 
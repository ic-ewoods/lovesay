<?php

namespace test\LoveSay;

use LoveSay\API\Notes;
use LoveSay\Note;
use LoveSay\NoteRepository;
use LoveSay\Originator;
use LoveSay\Persistence\Sqlite\SqliteNotesStorage;

class NoteRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var NoteRepository */
    private $repository;

    /** @var Notes */
    private $notes_api;

    /** @var Originator | \PHPUnit_Framework_MockObject_MockObject */
    private $originator;

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

        $this->notes_api = new Notes($this->originator, new SqliteNotesStorage());
        $this->repository = new NoteRepository($this->notes_api);
    }

    /**
     * @test
     */
    public function canBeInstantiated()
    {
        $note_api = $this->getMockBuilder('\LoveSay\API\Notes')
            ->disableOriginalConstructor()
            ->getMock();
        $repository = new NoteRepository($note_api);
        $this->assertInstanceOf('\LoveSay\NoteRepository', $repository);
    }

    /**
     * @test
     */
    public function canCreateNote()
    {
        $note = new Note("test", $this->originator->getKey());

        $created_note = $this->repository->createNote("test");

        $this->assertInstanceOf('\LoveSay\Note', $created_note);
        $this->assertEquals($note->getKey(), $created_note->getKey());
    }

    /**
     * @test
     */
    public function canAddNote()
    {
        $this->expectTwoNotes();
        $note = new Note('Thing Three?', $this->originator->getKey());

        $this->assertEquals(2, $this->repository->getCount());

        $this->repository->addNote($note);
        $this->assertEquals(3, $this->repository->getCount());
    }

    /**
     * @test
     */
    public function canGetCount()
    {
        $this->expectTwoNotes();
        $this->assertEquals(2, $this->repository->getCount());
    }

    /**
     * @test
     */
    public function canGetNote()
    {
        $this->expectTwoNotes();
        $id = Note::checksum("Thing One" . 1);
        $this->assertInstanceOf('\LoveSay\Note', $this->repository->getNote($id));
    }

    /**
     * @test
     */
    public function canGetAllNotes()
    {
        $this->expectTwoNotes();
        $notes = $this->repository->getAllNotes();
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
 
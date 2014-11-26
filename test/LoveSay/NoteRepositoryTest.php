<?php

namespace test\LoveSay;

use LoveSay\API\InMemoryNotes;
use LoveSay\API\NoteAPI;
use LoveSay\Note;
use LoveSay\NoteRepository;
use LoveSay\Originator;

class NoteRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var NoteRepository */
    private $repository;

    /** @var NoteAPI */
    private $note_api;

    /** @var Originator | \PHPUnit_Framework_MockObject_MockObject */
    private $originator;

    public function setup()
    {
        $this->originator = $this->getMockBuilder('\LoveSay\Originator')
            ->disableOriginalConstructor()
            ->getMock();
        $this->originator->method('getKey')
            ->willReturn(1);

        $this->note_api = new InMemoryNotes($this->originator);
        $this->repository = new NoteRepository($this->note_api);
    }

    /**
     * @test
     */
    public function canBeInstantiated()
    {
        $note_api = $this->getMockBuilder('\LoveSay\API\NoteAPI')
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
        $note = new Note("test", $this->originator);

        $created_note = $this->repository->createNote("test");

        $this->assertInstanceOf('\LoveSay\Note', $created_note);
        $this->assertEquals($note->getKey(), $created_note->getKey());
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
    public function canGetRandomNote()
    {
        $this->expectTwoNotes();
        $this->assertInstanceOf('\LoveSay\Note', $this->repository->getRandomNote());
    }

    /**
     * @test
     */
    public function canAddNote()
    {
        $this->expectTwoNotes();
        $note = new Note('Thing Three?', $this->originator);

        $this->assertEquals(2, $this->repository->getCount());

        $this->repository->addNote($note);
        $this->assertEquals(3, $this->repository->getCount());
    }

    public function expectTwoNotes()
    {
        $say = array(
            "Thing One",
            "Thing Two"
        );
        $this->note_api->load($say);
    }

}
 
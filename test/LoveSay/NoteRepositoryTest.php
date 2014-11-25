<?php

namespace test\LoveSay;

use LoveSay\API\InMemoryNotes;
use LoveSay\API\NoteAPI;
use LoveSay\Note;
use LoveSay\NoteRepository;

class NoteRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var NoteRepository */
    private $repository;

    /** @var NoteAPI */
    private $note_api;

    /**
     * @test
     */
    public function canBeInstantiated()
    {
        $this->expectInMemoryNotes();
        $repository = new NoteRepository($this->note_api);
        $this->assertInstanceOf('\LoveSay\NoteRepository', $repository);
    }

    public function canGetCount()
    {
        $this->expectRepository();
        $this->assertEquals(2, $this->repository->getCount());
    }

    /**
     * @test
     */
    public function canGetGetNote()
    {
        $this->expectRepository();
        $this->assertInstanceOf('\LoveSay\Note', $this->repository->getNote(1));
    }

    /**
     * @test
     */
    public function canGetRandomNote()
    {
        $this->expectRepository();
        $this->assertInstanceOf('\LoveSay\Note', $this->repository->getRandomNote());
    }

    /**
     * @test
     */
    public function canAddNote()
    {
        $this->expectRepository();
        $note = new Note('Thing Three?');
        $this->repository->addNote($note);
        $this->assertEquals(3, $this->repository->getCount());
    }

    private function expectRepository()
    {
        $this->expectInMemoryNotes();
        $this->repository = new NoteRepository($this->note_api);
    }

    private function expectInMemoryNotes()
    {
        $say = array(
            "Thing One",
            "Thing Two"
        );
        $this->note_api = new InMemoryNotes($say);
    }
}
 
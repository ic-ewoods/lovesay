<?php

namespace test\LoveSay;

use LoveSay\NoteCollection;

class NoteCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canBeInstantiated()
    {
        $note = new NoteCollection();
        $this->assertInstanceOf('\LoveSay\NoteCollection', $note);
    }

    /**
     * @test
     */
    public function implementsArrayAccess()
    {
        $this->assertTrue(new NoteCollection() instanceof \ArrayAccess);
    }

    /**
     * @test
     */
    public function implementsIterator()
    {
        $this->assertTrue(new NoteCollection() instanceof \Iterator);
    }

    /**
     * @test
     */
    public function implementsCountable()
    {
        $this->assertTrue(new NoteCollection() instanceof \Countable);
    }
}


///**
// * @return Note
// */
//public function getRandomNote()
//{
//    $selection = rand(1, $this->getCount());
//    $notes = $this->getAllNotes();
//
//    return $notes->get($selection - 1);
//}
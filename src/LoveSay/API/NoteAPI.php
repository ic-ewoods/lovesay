<?php

namespace LoveSay\API;

use LoveSay\Note;
use LoveSay\Originator;

interface NoteAPI
{

    /**
     * @return Originator
     */
    public function getNoteOriginator();

    /**
     * @return integer
     */
    public function getNoteCount();

    /**
     * @param integer $id
     *
     * @return Note|null
     *
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function getNote($id);

    /**
     * @param Note $note
     *
     * @return int
     */
    public function putNote(Note $note);

    /**
     * @return array
     */
    public function getAllNotes();

    /**
     * @param array $say
     */
    public function load(array $say);

}
 
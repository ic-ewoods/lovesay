<?php

namespace LoveSay\API;

use LoveSay\Note;

interface NoteAPI
{

    /**
     * @return integer
     */
    public function getNoteCount();

    /**
     * @param $id
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
    public function getAll();

}
 
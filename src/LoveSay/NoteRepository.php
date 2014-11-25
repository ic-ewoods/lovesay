<?php

namespace LoveSay;

use LoveSay\API\NoteAPI;

class NoteRepository
{
    /** @var NoteAPI */
    private $note_api;

    /**
     * @param NoteAPI $note_api
     */
    public function __construct(NoteAPI $note_api)
    {
        $this->note_api = $note_api;
    }

    /**
     * @param Note $note
     *
     * @return bool
     */
    public function addNote(Note $note)
    {
        return $this->note_api->putNote($note);
    }

    /**
     * @param $note_id
     *
     * @return Note|null
     */
    public function getNote($note_id)
    {
        $note = $this->note_api->getNote($note_id);

        return $note;
    }

    /**
     * @return Note
     */
    public function getRandomNote()
    {
        $note_id = rand(1, $this->getCount());
        $note = $this->note_api->getNote($note_id);

        return $note;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->note_api->getNoteCount();
    }

    /**
     * @return array
     */
    public function getAllNotes()
    {
        return $this->note_api->getAll();
    }

}

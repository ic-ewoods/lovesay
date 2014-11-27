<?php

namespace LoveSay;

use LoveSay\API\Notes;

class NoteRepository
{
    /** @var Notes */
    private $notes_api;

    /**
     * @param Notes $notes_api
     */
    public function __construct(Notes $notes_api)
    {
        $this->notes_api = $notes_api;
    }

    /**
     * @param $message
     *
     * @return Note
     */
    public function createNote($message)
    {
        return new Note($message, $this->notes_api->getOriginatorKey());
    }

    /**
     * @param Note $note
     *
     * @return bool
     */
    public function addNote(Note $note)
    {
        return $this->notes_api->putNote($note);
    }

    /**
     * @param $id
     *
     * @return Note|null
     */
    public function getNote($id)
    {
        return $this->notes_api->getNote($id);
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->notes_api->getNoteCount();
    }

    /**
     * @return NoteCollection
     */
    public function getAllNotes()
    {
        return $this->notes_api->getAllNotes();
    }


}

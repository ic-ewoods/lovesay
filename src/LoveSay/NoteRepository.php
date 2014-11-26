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

    public function createNote($message)
    {
        $note = new Note($message, $this->note_api->getNoteOriginator());

        return $note;
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
     * @param $id
     *
     * @return Note|null
     */
    public function getNote($id)
    {
        $note = $this->note_api->getNote($id);

        return $note;
    }

    /**
     * @return Note
     */
    public function getRandomNote()
    {
        $selection = rand(1, $this->getCount());
        $notes = $this->getAllNotes();

        return $notes[$selection - 1];
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
        return $this->note_api->getAllNotes();
    }


}

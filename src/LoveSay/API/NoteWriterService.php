<?php

namespace LoveSay\API;

use LoveSay\Note;
use LoveSay\NoteCollection;
use LoveSay\Originator;
use LoveSay\Persistence\NotesStorage;

class NoteWriterService
{
    /** @var int */
    private $originator_key;
    /** @var NotesStorage */
    private $storage;

    public function __construct(Originator $originator, NotesStorage $storage)
    {
        $this->originator_key = $originator->getKey();
        $this->storage = $storage;
    }

    /**
     * @return int
     */
    public function getCount()
    {

        return $this->storage->count($this->originator_key);
    }

    /**
     * @param int $note_key
     *
     * @return Note|null
     */
    public function getNote($note_key)
    {
        if ($note_data = $this->storage->fetch($this->originator_key, $note_key)) {
            return new Note($this->originator_key, $note_data->message);
        }

        return null;
    }

    /**
     * @param Note $note
     *
     * @return int
     */
    public function putNote(Note $note)
    {
        $note_data = array(
            'note_key'       => $note->getKey(),
            'message'        => $note->message()
        );
        return $this->storage->store($this->originator_key, $note_data);
    }

    /**
     * @return NoteCollection
     */
    public function getAllNotes()
    {
        $notes = $this->storage->fetchAll($this->originator_key);

        $all_notes = new NoteCollection();
        /** @var object $note_data */
        foreach ($notes as $note_data) {
            $all_notes->add(new Note($this->originator_key, $note_data->message));
        }
        return $all_notes;
    }

    /**
     * @param array $messages
     */
    public function importFromArray(array $messages)
    {
        foreach ($messages as $message) {
            $note = new Note($this->originator_key, $message);
            $this->putNote($note);
        }
    }
}
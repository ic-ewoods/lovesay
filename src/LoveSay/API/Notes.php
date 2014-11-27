<?php

namespace LoveSay\API;

use LoveSay\Freshness\FreshnessService;
use LoveSay\Note;
use LoveSay\NoteCollection;
use LoveSay\Originator;
use LoveSay\Persistence\NotesStorage;

class Notes
{
    /** @var int */
    protected $originator_key;
    /** @var NotesStorage */
    protected $storage;

    public function __construct(Originator $originator, NotesStorage $storage)
    {
        $this->originator_key = $originator->getKey();
        $this->storage = $storage;
    }

    /**
     * @return int
     */
    public function getOriginatorKey()
    {
        return $this->originator_key;
    }

    /**
     * @return int
     */
    public function getNoteCount()
    {

        return $this->storage->fetchCount($this->originator_key);
    }

    /**
     * @param int $id
     *
     * @return Note|null
     */
    public function getNote($id)
    {
        if ($note_data = $this->storage->fetchObject($this->originator_key, $id)) {
            return new Note($note_data->message, $this->originator_key);
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
        $id = $note->getKey();
        $message = $note->getText();

        return $this->storage->store($this->originator_key, $id, $message);
    }

    /**
     * @return NoteCollection
     */
    public function getAllNotes()
    {
        return $this->storage->fetchAll($this->originator_key);
    }

    /**
     * @param FreshnessService $freshness
     *
     * @return Note
     */
    public function getFreshNote(FreshnessService $freshness)
    {
        // TODO: Implement getFreshNote() method.
    }

    /**
     * @param array $messages
     */
    public function importFromArray(array $messages)
    {
        foreach ($messages as $message) {
            $note = new Note($message, $this->originator_key);
            $this->putNote($note);
        }
    }
}
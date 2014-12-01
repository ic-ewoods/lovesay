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
     * @param int $note_key
     *
     * @return Note|null
     */
    public function getNote($note_key)
    {
        if ($note_data = $this->storage->fetchObject($this->originator_key, $note_key)) {
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
        $note_key = $note->getKey();
        $message = $note->message();

        return $this->storage->store($this->originator_key, $note_key, $message);
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
     * @param FreshnessService $freshness
     *
     * @return Note
     */
    public function viewNote(FreshnessService $freshness)
    {
        $all_notes = $this->getAllNotes();
        $max_note = $all_notes->count() - 1;

        do {
            $note = $all_notes[rand(0, $max_note)];
        } while (!$freshness->isFresh(($note)));

        $this->storage->incrementViewCount($this->originator_key, $note->getKey());

        return $note;
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
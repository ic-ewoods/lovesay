<?php

namespace LoveSay\API;

use LoveSay\Note;
use LoveSay\NoteCollection;
use LoveSay\Persistence\NotesStorage;
use LoveSay\Relationship;

class NoteWriterService
{
    /** @var int */
    private $relationship_key;
    /** @var NotesStorage */
    private $storage;

    public function __construct(Relationship $relationship, NotesStorage $storage)
    {
        $this->relationship_key = $relationship->getKey();
        $this->storage = $storage;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->storage->count($this->relationship_key);
    }

    /**
     * @param int $note_key
     *
     * @return Note|null
     */
    public function getNote($note_key)
    {
        if ($note_data = $this->storage->fetch($this->relationship_key, $note_key)) {
            return new Note($this->relationship_key, $note_data->message);
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
            'message'        => $note->getMessage()
        );
        return $this->storage->store($this->relationship_key, $note_data);
    }

    /**
     * @return NoteCollection
     */
    public function getAllNotes()
    {
        $notes = $this->storage->fetchAll($this->relationship_key);

        $all_notes = new NoteCollection();
        /** @var object $note_data */
        foreach ($notes as $note_data) {
            $all_notes->add(new Note($this->relationship_key, $note_data->message, $note_data->view_count));
        }
        return $all_notes;
    }

    /**
     * @param array $messages
     */
    public function importFromArray(array $messages)
    {
        foreach ($messages as $message) {
            $note = new Note($this->relationship_key, $message);
            $this->putNote($note);
        }
    }
}
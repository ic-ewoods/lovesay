<?php

namespace LoveSay\API;

use LoveSay\Note;
use LoveSay\Persistence\NotesStorage;
use LoveSay\Relationship;

class NoteReaderService
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
     * @param int $note_key
     *
     * @return Note|null
     */
    public function readNote($note_key)
    {
        if ($note_data = $this->storage->fetch($this->relationship_key, $note_key)) {
            $note = new Note($this->relationship_key, $note_data->message, $note_data->view_count);
            $note->incrementViewCount();
            $this->storage->update($this->relationship_key, $note);

            return $note;
        }

        return null;
    }

} 
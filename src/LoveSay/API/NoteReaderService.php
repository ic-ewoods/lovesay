<?php

namespace LoveSay\API;

use LoveSay\Freshness\FreshnessService;
use LoveSay\Note;
use LoveSay\NoteCollection;
use LoveSay\Originator;
use LoveSay\Persistence\NotesStorage;
use LoveSay\Recipient;

class NoteReaderService
{
    /** @var int */
    private $recipient_key;
    /** @var NotesStorage */
    private $storage;

    public function __construct(Recipient $recipient, NotesStorage $storage)
    {
        $this->recipient_key = $recipient->getKey();
        $this->storage = $storage;
    }

    /**
     * @param Originator $originator
     * @param int        $note_key
     *
     * @return Note|null
     */
    public function getNote(Originator $originator, $note_key)
    {
        if ($note_data = $this->storage->fetch($originator->getKey(), $note_key)) {
            $note = new Note($originator->getKey(), $note_data->message, $note_data->view_count);
            $note->incrementViewCount();
            $this->storage->update($originator->getKey(), $note);

            return $note;
        }

        return null;
    }

    /**
     * @return NoteCollection
     */
    private function getAllNotes()
    {
        $notes = $this->storage->fetchAll($this->recipient_key);

        $all_notes = new NoteCollection();
        /** @var object $note_data */
        foreach ($notes as $note_data) {
            $all_notes->add(new Note($this->recipient_key, $note_data->message, $note_data->view_count));
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

        $note->incrementViewCount();
        $this->storage->update($this->recipient_key, $note);

        return $note;
    }

} 
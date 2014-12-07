<?php

namespace LoveSay\API;

use LoveSay\Freshness\FreshnessService;
use LoveSay\Note;
use LoveSay\NoteCollection;
use LoveSay\Persistence\NotesStorage;
use LoveSay\Relationship;

class NoteDistributionService
{
    /** @var NotesStorage */
    private $storage;

    public function __construct(NotesStorage $storage)
    {
        $this->storage = $storage;
    }

    public function getFreshNote(Relationship $relationship, FreshnessService $freshness)
    {
        $relationship_key = $relationship->getKey();
        $all_notes = $this->getAllNotes($relationship);
        $max_note = $all_notes->count() - 1;

        do {
            $note = $all_notes[rand(0, $max_note)];
        } while (!$freshness->isFresh(($note)));


        return $note;
    }

    /**
     * @param int $relationship_key
     *
     * @return NoteCollection
     */
    private function getAllNotes($relationship_key)
    {
        $notes = $this->storage->fetchAll($relationship_key);

        $all_notes = new NoteCollection();
        /** @var object $note_data */
        foreach ($notes as $note_data) {
            $all_notes->add(new Note($relationship_key, $note_data->message, $note_data->view_count));
        }
        return $all_notes;
    }

}
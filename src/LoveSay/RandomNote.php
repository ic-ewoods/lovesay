<?php

namespace LoveSay;

class RandomNote
{
    /**
     * @return string
     */
    function getNote()
    {
        $note_repository = new NoteRepository();
        $note = $note_repository->getRandomNote();

        return $note->getText();
    }
}

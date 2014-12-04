<?php

namespace LoveSay\Freshness;

use LoveSay\Note;

class Any implements FreshnessService
{

    /**
     * @param Note $note
     *
     * @return boolean
     */
    public function isFresh(Note $note)
    {
        return true;
    }
}
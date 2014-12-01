<?php

namespace LoveSay\Freshness;

use LoveSay\Note;

class True implements FreshnessService
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
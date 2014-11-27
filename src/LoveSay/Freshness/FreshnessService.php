<?php

namespace LoveSay\Freshness;

use LoveSay\Note;

interface FreshnessService
{
    public function isFresh(Note $note);
}
 
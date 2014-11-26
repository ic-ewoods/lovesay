<?php

namespace LoveSay\API;

use Aura\Sql\ExtendedPdo;
use LoveSay\Originator;

class InMemoryNotes extends SqliteNotes
{

    public function __construct(Originator $originator, array $config = null)
    {
        $this->pdo = new ExtendedPdo('sqlite::memory:');

        parent::__construct($originator);
    }


}
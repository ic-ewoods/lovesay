<?php

namespace LoveSay\API;

use Aura\Sql\ExtendedPdo;
use LoveSay\Note;
use LoveSay\Originator;

class FileNotes extends SqliteNotes
{
    /**
     * @param Originator $originator
     * @param array      $config
     */
    public function __construct(Originator $originator, array $config = null)
    {
        if (empty($config) || !array_key_exists('filename', $config)) {
            throw new \InvalidArgumentException('FileNotes require filename config');
        }
        $this->pdo = new ExtendedPdo("sqlite:{$config['filename']}");

        parent::__construct($originator);
    }

}
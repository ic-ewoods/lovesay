<?php

namespace LoveSay\Persistence;

use LoveSay\NoteCollection;

interface NotesStorage
{
    /**
     * @param $originator_key
     *
     * @return integer
     */
    public function fetchCount($originator_key);

    /**
     * @param $originator_key
     * @param $id
     *
     * @return object
     */
    public function fetchObject($originator_key, $id);

    /**
     * @param int $originator_key
     * @param int $id
     * @param string $message
     *
     * @return int
     */
    public function store($originator_key, $id, $message);

    /**
     * @param int $originator_key
     *
     * @return NoteCollection
     */
    public function fetchAll($originator_key);

} 
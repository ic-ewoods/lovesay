<?php

namespace LoveSay\Persistence;

interface NotesStorage
{
    /**
     * @param $originator_key
     *
     * @return int
     */
    public function fetchCount($originator_key);

    /**
     * @param $originator_key
     * @param $note_key
     *
     * @return object
     */
    public function fetchObject($originator_key, $note_key);

    /**
     * @param int $originator_key
     *
     * @return array
     */
    public function fetchAll($originator_key);

    /**
     * @param int $originator_key
     * @param int $note_key
     * @param string $message
     *
     * @return int
     */
    public function store($originator_key, $note_key, $message);


    /**
     * @param int $originator_key
     * @param int $note_key
     *
     * @return int
     */
    public function incrementViewCount($originator_key, $note_key);
} 
<?php

namespace LoveSay\Persistence;

use LoveSay\Note;

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
     * @param int    $originator_key
     * @param int    $note_key
     * @param string $message
     * @param int    $view_count
     *
     * @return int
     */
    public function store($originator_key, $note_key, $message, $view_count = 0);


    /**
     * @param int  $originator_key
     * @param Note $note
     *
     * @return int
     */
    public function update($originator_key, Note $note);

} 
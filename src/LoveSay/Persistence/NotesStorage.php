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
    public function count($originator_key);

    /**
     * @param $originator_key
     * @param $note_key
     *
     * @return object
     */
    public function fetch($originator_key, $note_key);

    /**
     * @param int $originator_key
     *
     * @return array
     */
    public function fetchAll($originator_key);

    /**
     * @param int   $originator_key
     * @param array $note_data
     *
     * @internal param Note $note
     *
     * @return int
     */
    public function store($originator_key, array $note_data);


    /**
     * @param int  $originator_key
     * @param Note $note
     *
     * @return int
     */
    public function update($originator_key, Note $note);

} 
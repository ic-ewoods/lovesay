<?php

namespace LoveSay\Persistence;

use LoveSay\Note;

interface NotesStorage
{
    /**
     * @param $relationship_key
     *
     * @return int
     */
    public function count($relationship_key);

    /**
     * @param $relationship_key
     * @param $note_key
     *
     * @return object
     */
    public function fetch($relationship_key, $note_key);

    /**
     * @param $relationship_key
     *
     * @return array
     */
    public function fetchAll($relationship_key);

    /**
     * @param       $relationship_key
     * @param array $note_data
     *
     * @return int
     */
    public function store($relationship_key, array $note_data);


    /**
     * @param      $relationship_key
     * @param Note $note
     *
     * @return int
     */
    public function update($relationship_key, Note $note);

} 
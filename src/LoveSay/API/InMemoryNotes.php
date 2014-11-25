<?php

namespace LoveSay\API;

use Aura\Sql\ExtendedPdo;
use Aura\SqlQuery\QueryFactory;
use LoveSay\Note;

class InMemoryNotes implements NoteAPI
{
    public function __construct(array $say = array())
    {
        $this->pdo = new ExtendedPdo('sqlite::memory:');
        $this->query_factory = new QueryFactory('sqlite');

        $this->pdo->exec("CREATE TABLE notes (
                      id INTEGER PRIMARY KEY,
                      message TEXT
                      )");

        foreach ($say as $message) {
            $note = new Note($message);
            $this->putNote($note);
        }
    }

    /**
     * @return integer
     */
    public function getNoteCount()
    {
        $select = $this->query_factory->newSelect();
        $select->cols(array('COUNT(*) AS count'))->from('notes');

        $count = $this->pdo->fetchValue($select);

        return $count;
    }

    /**
     * @param $id
     *
     * @return Note|null
     */
    public function getNote($id)
    {
        $select = $this->query_factory->newSelect();
        $select->cols(array('id', 'message'))
            ->from('notes')
            ->where('id = ?', $id);

        $note_data = $this->pdo->fetchObject($select, $select->getBindValues());
        $note = new Note($note_data->message);

        return $note;
    }

    /**
     * @param Note $note
     *
     * @return int
     */
    public function putNote(Note $note)
    {
        $data_mapping = array(
            'message' => $note->getText()
        );

        $insert = $this->query_factory->newInsert();
        $insert->into('notes')->cols($data_mapping);

        $this->pdo->perform($insert, $insert->getBindValues());

        return $this->pdo->lastInsertId();
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $select = $this->query_factory->newSelect();
        $select->cols(array('id', 'message'))
            ->from('notes');

        $notes = $this->pdo->fetchObjects($select, $select->getBindValues());
        $all_notes = array();
        foreach ($notes as $note_data) {
            $all_notes[] = new Note($note_data->message);
        }

        return $all_notes;
    }
}
<?php

namespace LoveSay\API;

use Aura\Sql\ExtendedPdo;
use Aura\SqlQuery\QueryFactory;
use LoveSay\Note;
use LoveSay\Originator;

abstract class SqliteNotes implements NoteAPI
{
    /** @var Originator */
    protected $originator;
    /** @var QueryFactory */
    protected $query_factory;
    /** @var ExtendedPdo; */
    protected $pdo;

    protected function __construct(Originator $originator, array $config = null)
    {
        $this->originator = $originator;
        $this->query_factory = new QueryFactory('sqlite');

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS notes (
                      id INTEGER PRIMARY KEY,
                      originator_key INTEGER,
                      message TEXT
                      )");
    }

    public function getNoteOriginator()
    {
        return $this->originator;
    }

    /**
     * @return integer
     */
    public function getNoteCount()
    {
        $select = $this->query_factory->newSelect();
        $select->cols(array('COUNT(*) AS count'))
            ->from('notes')
            ->where('originator_key = ?', $this->originator->getKey());

        $count = $this->pdo->fetchValue($select, $select->getBindValues());

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
        $select->cols(array('message'))
            ->from('notes')
            ->where('id = ?', $id)
            ->where('originator_key = ?', $this->originator->getKey());

        $note_data = $this->pdo->fetchObject($select, $select->getBindValues());

        if (empty($note_data)) return null;

        $note = new Note($note_data->message, $this->originator);

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
            'id'             => $note->getKey(),
            'originator_key' => $this->originator->getKey(),
            'message'        => $note->getText()
        );

        $insert = $this->query_factory->newInsert();
        $insert->into('notes')->cols($data_mapping);

        $this->pdo->perform($insert, $insert->getBindValues());

        return $this->pdo->lastInsertId();
    }

    /**
     * @return array
     */
    public function getAllNotes()
    {
        $select = $this->query_factory->newSelect();
        $select->cols(array('message'))
            ->from('notes')
            ->where('originator_key = ?', $this->originator->getKey());

        $notes = $this->pdo->fetchObjects($select, $select->getBindValues());
        $all_notes = array();
        foreach ($notes as $note_data) {
            $all_notes[] = new Note($note_data->message, $this->originator);
        }

        return $all_notes;
    }

    /**
     * @param array $say
     */
    public function load(array $say)
    {
        foreach ($say as $message) {
            $note = new Note($message, $this->originator);
            $this->putNote($note);
        }
    }
}